Usage
-----

The following example assume that :

* `MyDatabaseUsageFinder` & `MyFilesystemUsageFinder` are valid [usage finders](components/usage-finder.md)
* `MyUsageDescriptor` is a valid [object descriptor](components/object-descriptor.md)
* `$resource` is an object that is supported by your components above

> **note** you may not be required to create your own components, have a look to our [integrations](integration).


```php
<?php

use Yokai\SafeDelete\Usage\Descriptor\ObjectDescriptor;
use Yokai\SafeDelete\Usage\Finder\UsageFinder;

$usageFinder = new UsageFinder([
    new MyDatabaseUsageFinder(),
    new MyFilesystemUsageFinder(),
]);

if ($usageFinder->count($resource) !== 0) {
    $objectDescriptor = new ObjectDescriptor([
        new MyUsageDescriptor(),
    ]);

    foreach ($usageFinder->find($resource) as $usage) {
        echo $objectDescriptor->describe($usage), PHP_EOL;
    }

    exit(1);
}

// here, $resource can be safely deleted
```



---

« [Concepts](2-concepts.md) • [README](../README.md) »
