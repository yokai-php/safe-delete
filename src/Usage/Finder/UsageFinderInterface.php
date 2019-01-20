<?php

namespace Yokai\SafeDelete\Usage\Finder;

use Yokai\SafeDelete\Usage\Usage;
use Yokai\SafeDelete\Usage\Relation;

interface UsageFinderInterface
{
    /**
     * @param object $object
     * @param array  $strategies
     *
     * @return int
     */
    public function count(object $object, array $strategies = Relation::BLOCKING): int;

    /**
     * @param object $object
     * @param array  $strategies
     *
     * @return iterable|Usage[]
     */
    public function find(object $object, array $strategies = Relation::BLOCKING): iterable;
}
