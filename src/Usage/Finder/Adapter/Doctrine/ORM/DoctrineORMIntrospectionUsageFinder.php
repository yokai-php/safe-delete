<?php

namespace Yokai\SafeDelete\Usage\Finder\Adapter\Doctrine\ORM;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\QueryBuilder;
use Yokai\SafeDelete\Usage\Finder\SupportsUsageFinderInterface;
use Yokai\SafeDelete\Usage\Relation;
use Yokai\SafeDelete\Usage\Usage;

class DoctrineORMIntrospectionUsageFinder implements SupportsUsageFinderInterface
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @inheritdoc
     */
    public function supports(object $object): bool
    {
        try {
            $this->getManagerForClass($this->getClassName($object));
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function count(object $object, array $strategies = Relation::BLOCKING): int
    {
        $count = 0;

        foreach ($this->getRelations($object, $strategies) as $relation) {
            $result = $this->getQueryForClassAndProperty($relation->getRelatedType(), $relation->getProperty(), $object)
                ->select('COUNT(o)')
                ->getQuery()
                ->getSingleScalarResult();

            $count += intval($result);
        }

        return $count;
    }

    /**
     * @inheritdoc
     */
    public function find(object $object, array $strategies = Relation::BLOCKING): iterable
    {
        foreach ($this->getRelations($object, $strategies) as $relation) {
            $usages = $this->getQueryForClassAndProperty($relation->getRelatedType(), $relation->getProperty(), $object)
                ->getQuery()
                ->getResult();

            foreach ($usages as $usage) {
                yield new Usage($object, $relation, $usage);
            }
        }
    }

    /**
     * @param object $object
     * @param array  $strategies
     *
     * @return \Generator|Relation[]
     */
    private function getRelations(object $object, array $strategies): \Generator
    {
        $className = $this->getClassName($object);

        $metadataCollection = $this->getManagerForClass($className)
            ->getMetadataFactory()
            ->getAllMetadata();

        foreach ($metadataCollection as $classMetadata) {
            if (!$classMetadata instanceof ClassMetadataInfo) {
                throw new \LogicException();//todo
            }

            foreach ($classMetadata->getAssociationsByTargetClass($className) as $property => $association) {
                if ($association['isOwningSide'] === false) {
                    continue;
                }

                $strategy = $this->getStrategyFromAssociationMapping($association);
                if (!in_array($strategy, $strategies, true)) {
                    continue;
                }

                yield Relation::get($classMetadata->getName(), $property, $strategy);
            }
        }
    }

    private function getQueryForClassAndProperty(string $className, string $property, object $object): QueryBuilder
    {
        $query = $this->getRepositoryForClass($className)
            ->createQueryBuilder('o');
        $mapping = $this->getMetadataForClass($className)
            ->getAssociationMapping($property);

        if ($mapping['type'] & ClassMetadata::TO_MANY) {
            $objectMetadata = $this->getMetadataForClass(get_class($object));
            $idFieldName = $objectMetadata->getIdentifierFieldNames()[0];
            $objectId = $objectMetadata->getIdentifierValues($object)[$idFieldName];
            $query->innerJoin("o.$property", 'p')
                ->where("p.$idFieldName = :objectId")
                ->setParameter('objectId', $objectId);
        } else {
            $query->where("o.$property = :object")
                ->setParameter('object', $object);
        }

        return $query;
    }

    private function getManagerForClass(string $className): EntityManagerInterface
    {
        $manager = $this->doctrine->getManagerForClass($className);
        if (!$manager instanceof EntityManagerInterface) {
            throw new \LogicException();//todo
        }

        return $manager;
    }

    private function getRepositoryForClass(string $className): EntityRepository
    {
        $repository = $this->doctrine->getRepository($className);
        if (!$repository instanceof EntityRepository) {
            throw new \LogicException();//todo
        }

        return $repository;
    }

    private function getMetadataForClass(string $className): ClassMetadataInfo
    {
        $metadata = $this->getManagerForClass($className)->getClassMetadata($className);
        if (!$metadata instanceof ClassMetadataInfo) {
            throw new \LogicException();//todo
        }

        return $metadata;
    }

    private function getClassName(object $object): string
    {
        return get_class($object);
    }

    private function getStrategyFromAssociationMapping(array $mapping): string
    {
        if ($mapping['type'] === ClassMetadata::MANY_TO_MANY) {
            return Relation::DELETE;
        }

        $map = [
            'CASCADE' => Relation::DELETE,
            'SET NULL' => Relation::UNLINK,
            'NO ACTION' => Relation::RESTRICT,
            'RESTRICT' => Relation::RESTRICT,
            'SET DEFAULT' => Relation::UNLINK,
        ];

        return $map[mb_strtoupper($mapping['joinColumns'][0]['onDelete'] ?? 'RESTRICT')] ?? Relation::RESTRICT;
    }
}
