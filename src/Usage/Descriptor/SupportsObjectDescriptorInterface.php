<?php

namespace Yokai\SafeDelete\Usage\Descriptor;

interface SupportsObjectDescriptorInterface extends ObjectDescriptorInterface
{
    /**
     * @param object $object
     *
     * @return bool
     */
    public function supports(object $object): bool;
}
