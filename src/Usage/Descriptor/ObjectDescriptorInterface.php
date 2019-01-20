<?php

namespace Yokai\SafeDelete\Usage\Descriptor;

interface ObjectDescriptorInterface
{
    /**
     * @param object $object
     *
     * @return string
     */
    public function describe(object $object): string;
}
