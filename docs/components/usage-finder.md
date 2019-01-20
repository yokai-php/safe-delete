Usage Finder
------------

The [UsageFinderInterface](../../src/Usage/Finder/UsageFinderInterface.php)
is the interface for components that aim to find usages of resources.

But you should be more interested in the 
[SupportsUsageFinderInterface](../../src/Usage/Finder/SupportsUsageFinderInterface.php),
which combined with [UsageFinder](../../src/Usage/Finder/UsageFinder.php) 
allow to have multiple usage finder at once.

Example :

```php
<?php

use Yokai\SafeDelete\Usage\Finder\UsageFinder;
use Yokai\SafeDelete\Usage\Finder\SupportsUsageFinderInterface;

$descriptor = new UsageFinder([
    new class implements SupportsUsageFinderInterface {/* ... */},
    new class implements SupportsUsageFinderInterface {/* ... */},
    /* ... */
]);

echo $descriptor->count($object); // any positive integer
echo $descriptor->find($object); // list of usages (possibly empty)
```


> **integration** this library is shipped with adapters for
> [doctrine/orm](../integration/doctrine-orm.md)

> **recipe** if you wish to create your own usage finder,
> please follow our [recipe](../recipes/custom-usage-finder.md)



---

« [README](../../README.md)
