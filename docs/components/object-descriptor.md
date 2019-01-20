Object Descriptor
-----------------

The [ObjectDescriptorInterface](../../src/Usage/Descriptor/ObjectDescriptorInterface.php)
is the interface for components that contains logic to describe objects.

But you should be more interested in the 
[SupportsObjectDescriptorInterface](../../src/Usage/Descriptor/SupportsObjectDescriptorInterface.php),
which combined with [ObjectDescriptor](../../src/Usage/Descriptor/ObjectDescriptor.php) 
allow to have multiple object descriptor at once.

Example :

```php
<?php

use Yokai\SafeDelete\Usage\Descriptor\ObjectDescriptor;
use Yokai\SafeDelete\Usage\Descriptor\SupportsObjectDescriptorInterface;

$descriptor = new ObjectDescriptor([
    new class implements SupportsObjectDescriptorInterface {/* ... */},
    new class implements SupportsObjectDescriptorInterface {/* ... */},
    /* ... */
]);

echo $descriptor->describe($object); // some string
```


> **integration** this library is shipped with adapters for
> [symfony/translation](../integration/symfony-translation.md),
> [symfony/property-access](../integration/symfony-property-access.md)

> **recipe** if you wish to create your own object descriptor,
> please follow our [recipe](../recipes/custom-object-descriptor.md)



---

« [README](../../README.md)
