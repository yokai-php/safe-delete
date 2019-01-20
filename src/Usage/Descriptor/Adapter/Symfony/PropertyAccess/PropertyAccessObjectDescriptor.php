<?php

namespace Yokai\SafeDelete\Usage\Descriptor\Adapter\Symfony\PropertyAccess;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Yokai\SafeDelete\Usage\Descriptor\SupportsObjectDescriptorInterface;

class PropertyAccessObjectDescriptor implements SupportsObjectDescriptorInterface
{
    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;

    /**
     * @var string
     */
    private $propertyPath;

    /**
     * @var string|null
     */
    private $objectClass;

    /**
     * @param PropertyAccessorInterface $propertyAccessor
     * @param string                    $propertyPath
     * @param string|null               $objectClass
     */
    public function __construct(PropertyAccessorInterface $propertyAccessor, string $propertyPath, ?string $objectClass)
    {
        $this->propertyAccessor = $propertyAccessor;
        $this->propertyPath = $propertyPath;
        $this->objectClass = $objectClass;
    }

    /**
     * @inheritdoc
     */
    public function supports(object $object): bool
    {
        return $this->objectClass === null || $object instanceof $this->objectClass;
    }

    /**
     * @inheritdoc
     */
    public function describe(object $object): string
    {
        return $this->propertyAccessor->getValue($object, $this->propertyPath);
    }
}
