<?php

namespace Yokai\SafeDelete\Usage\Descriptor;

interface ObjectDescriptorAwareInterface
{
    /**
     * @param ObjectDescriptorInterface $objectDescriptor
     */
    public function setObjectDescriptor(ObjectDescriptorInterface $objectDescriptor): void;
}
