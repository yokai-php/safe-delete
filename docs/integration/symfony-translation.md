Symfony Translation integration
-----------------------------------

The `symfony/translation` library provides tools to internationalize your application.


### Object Descriptor

The [TranslationUsageDescriptor](../../src/Usage/Descriptor/Adapter/Symfony/Translation/TranslationUsageDescriptor.php)²
is an [object descriptor](../components/object-descriptor.md) 
that uses translation to describe any usage object, 
delegating underlying objects description to the main descriptor.

Example : 

```php
<?php

use Yokai\SafeDelete\Usage\Descriptor\ObjectDescriptor;
use Yokai\SafeDelete\Usage\Descriptor\Adapter\Symfony\Translation\TranslationUsageDescriptor;

$descriptor = new ObjectDescriptor([
    new TranslationUsageDescriptor(
        $translator, // refer to symfony/translation documentation to know how to create a translator instance
        'deletion.usage.description' // let's say this is referring to "Object %subject% is used by %related%."
    )
]);

echo $descriptor->describe($usage); // "Object (subject description) is used by (related description)"
```

> **integrations** jump to other adapters :
> [symfony/property-access](../integration/symfony-property-access.md)



---

« [README](../../README.md)
