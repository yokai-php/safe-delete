<?php

namespace Yokai\SafeDelete\Usage\Finder;

interface SupportsUsageFinderInterface extends UsageFinderInterface
{
    /**
     * @param object $object
     *
     * @return bool
     */
    public function supports(object $object): bool;
}
