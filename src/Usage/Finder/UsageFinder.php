<?php

namespace Yokai\SafeDelete\Usage\Finder;

use Yokai\SafeDelete\Usage\Relation;

class UsageFinder implements UsageFinderInterface
{
    /**
     * @var iterable|UsageFinderInterface[]
     */
    private $finders;

    /**
     * @param iterable|UsageFinderInterface[] $finders
     */
    public function __construct(iterable $finders)
    {
        $this->finders = $finders;
    }

    /**
     * @inheritdoc
     */
    public function count(object $object, array $strategies = Relation::BLOCKING): int
    {
        $count = 0;
        foreach ($this->locateFindersFor($object) as $finder) {
            $count += $finder->count($object, $strategies);
        }

        return $count;
    }

    /**
     * @inheritdoc
     */
    public function find(object $object, array $strategies = Relation::BLOCKING): iterable
    {
        foreach ($this->locateFindersFor($object) as $finder) {
            yield from $finder->find($object, $strategies);
        }
    }

    /**
     * @param object $object
     *
     * @return UsageFinderInterface[]|\Generator
     */
    private function locateFindersFor(object $object): \Generator
    {
        foreach ($this->finders as $usageFinder) {
            if ($usageFinder instanceof SupportsUsageFinderInterface && !$usageFinder->supports($object)) {
                continue;
            }

            yield $usageFinder;
        }
    }
}
