Symfony Property Access integration
-----------------------------------

The `symfony/property-access` library provides function to read and write from/to an object or array 
using a simple string notation.


### Object Descriptor

The [PropertyAccessObjectDescriptor](../../src/Usage/Descriptor/Adapter/Symfony/PropertyAccess/PropertyAccessObjectDescriptor.php)²
is an [object descriptor](../components/object-descriptor.md) 
that uses property path to describe an object with the value behind it.

Example :

```php
<?php

use Yokai\SafeDelete\Usage\Descriptor\Adapter\Symfony\PropertyAccess\PropertyAccessObjectDescriptor;
use Yokai\SafeDelete\Usage\Descriptor\ObjectDescriptor;

class Page
{
    /** @var Metadata */
    public $metadata;
}

class Metadata
{
    /** @var string */
    public $title;
}

$page = new Page();
$page->metadata = $metadata = new Metadata();
$metadata->title = 'Homepage';

$descriptor = new ObjectDescriptor([
    new PropertyAccessObjectDescriptor(
        $propertyAccessor, // refer to symfony/property-access documentation to know how to create a property accessor instance
        'metadata.title',
       Page::class
    ),
]);

echo $descriptor->describe($page); // "Homepage"
```


> **integrations** jump to other adapters :
> [symfony/translation](../integration/symfony-translation.md)



---

« [README](../../README.md)
