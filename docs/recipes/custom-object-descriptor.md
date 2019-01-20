Custom Object Descriptor recipe
-------------------------------

Writing an [object descriptor](../components/object-descriptor.md) is as easy as 
creating a class that implements the [ObjectDescriptorInterface](../../src/Usage/Descriptor/ObjectDescriptorInterface.php).
But again it is highly recommended to implement 
the [SupportsObjectDescriptorInterface](../../src/Usage/Descriptor/SupportsObjectDescriptorInterface.php).

Example :

```php
<?php

use Yokai\SafeDelete\Usage\Descriptor\SupportsObjectDescriptorInterface;

class ApiResourceUsageFinder implements SupportsObjectDescriptorInterface
{
    public function supports(object $object): bool
    {
        return $object instanceof ApiResourceInterface;
    }

    public function describe(object $object): string 
    {
        return sprintf(
            '%s (from %s domain with %s identity)',
            (string) $object,
            $object->getDomain(),
            $object->getIdentity() ?: 'none'
        );
    }
}
```



---

« [README](../../README.md)
