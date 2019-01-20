<?php

namespace Yokai\SafeDelete\Usage\Descriptor;

class ObjectDescriptor implements ObjectDescriptorInterface
{
    /**
     * @var iterable|ObjectDescriptorInterface[]
     */
    private $descriptors;

    /**
     * @param iterable|ObjectDescriptorInterface[] $descriptors
     */
    public function __construct(iterable $descriptors)
    {
        $this->descriptors = $descriptors;

        foreach ($descriptors as $descriptor) {
            if ($descriptor instanceof ObjectDescriptorAwareInterface) {
                $descriptor->setObjectDescriptor($this);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function describe(object $object): string
    {
        if (null !== $descriptor = $this->locateDescriptor($object)) {
            return $descriptor->describe($object);
        }

        if (method_exists($object, '__toString')) {
            return (string)$object;
        }

        throw new \LogicException(
            sprintf(
                'Object of class "%s" cannot be described. '.
                'Either register a descriptor for these objects, or implement "__toString" method.',
                get_class($object)
            )
        );
    }

    /**
     * @param object $object
     *
     * @return ObjectDescriptorInterface|null
     */
    private function locateDescriptor(object $object): ?ObjectDescriptorInterface
    {
        foreach ($this->descriptors as $descriptor) {
            if ($descriptor instanceof SupportsObjectDescriptorInterface && !$descriptor->supports($object)) {
                continue;
            }

            return $descriptor;
        }

        return null;
    }
}
