Custom Usage Finder recipe
--------------------------

Writing an [usage finder](../components/usage-finder.md) is as easy as 
creating a class that implements the [UsageFinderInterface](../../src/Usage/Finder/UsageFinderInterface.php).
But again it is highly recommended to implement 
the [SupportsUsageFinderInterface](../../src/Usage/Finder/SupportsUsageFinderInterface.php).

Example :

```php
<?php

use Yokai\SafeDelete\Usage\Finder\SupportsUsageFinderInterface;
use Yokai\SafeDelete\Usage\Usage;
use Yokai\SafeDelete\Usage\Relation;

class ApiResourceUsageFinder implements SupportsUsageFinderInterface
{
    private const ON_DELETE_MAP = [
        'cascade' => Relation::DELETE,
        'set-null' => Relation::UNLINK,
        'throw' => Relation::RESTRICT,
    ];

    public function supports(object $object): bool
    {
        return $object instanceof ApiResourceInterface
            && $object->hasIdentity() !== null;
    }

    public function count(object $object, array $strategies = Relation::BLOCKING): int
    {
        return (int) $this->getApiResult($object)['count']['total'] ?? 0;
    }

    public function find(object $object, array $strategies = Relation::BLOCKING): iterable
    {
        foreach ($this->getApiResult($object)['items'] as $item) {
            yield new Usage(
                $object,
                Relation::get(
                    $item['link']['type'],
                    $item['link']['bind'],
                    self::ON_DELETE_MAP[$item['link']['onDelete']] ?? Relation::RESTRICT
                ),
                (object) $item
            );
        }
    }

    private function getApiResult(ApiResourceInterface $object): array
    {
        return json_decode($this->callApi($object), true);
    }

    private function callApi(ApiResourceInterface $object): string 
    {
        return file_get_contents($this->buildUrl($object));
    }

    private function buildUrl(ApiResourceInterface $object): string
    {
        return sprintf('https://api.my-domain.org/referers/%s]', $object->getIdentity());
    }
}
```



---

« [README](../../README.md)
