<?php

namespace Yokai\SafeDelete\Usage\Descriptor;

trait ObjectDescriptorAwareTrait
{
    /**
     * @var ObjectDescriptorInterface
     */
    private $objectDescriptor;

    /**
     * @param ObjectDescriptorInterface $objectDescriptor
     */
    public function setObjectDescriptor(ObjectDescriptorInterface $objectDescriptor): void
    {
        $this->objectDescriptor = $objectDescriptor;
    }
}
