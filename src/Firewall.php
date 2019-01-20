<?php

namespace Yokai\SafeDelete;

use Yokai\SafeDelete\Usage\Finder\UsageFinderInterface;
use Yokai\SafeDelete\Usage\Relation;

class Firewall
{
    /**
     * @var UsageFinderInterface
     */
    private $usageFinder;

    public function __construct(UsageFinderInterface $usageFinder)
    {
        $this->usageFinder = $usageFinder;
    }

    public function allow(object $object, array $strategies = Relation::BLOCKING): bool
    {
        return $this->usageFinder->count($object, $strategies) > 0;
    }
}
