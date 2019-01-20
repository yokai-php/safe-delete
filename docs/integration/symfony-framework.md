Symfony Framework integration
-----------------------------

### Registering the Bundle

Nothing special here, just add the bundle to your config.

```php
<?php
// config/bundles.php

return [
    /*...*/
    Yokai\SafeDelete\Bridge\Symfony\Framework\Bundle\YokaiSafeDeleteBundle::class => ['all' => true],
];
```


### Services automatically registered

In all case, the bundle will register following services :

- `yokai_safe_delete.usage_finder` (also aliased to `Yokai\SafeDelete\Usage\Finder\UsageFinderInterface`)
- `yokai_safe_delete.object_descriptor` (also aliased to `Yokai\SafeDelete\Usage\Descriptor\ObjectDescriptorInterface`)

These services will be filled with other services, tagged with the same name, ie :

- `yokai_safe_delete.usage_finder` for `yokai_safe_delete.usage_finder`
- `yokai_safe_delete.object_descriptor` for `yokai_safe_delete.object_descriptor`


In some case, the bundle may also register some more services :

- if your project is using `doctrine/orm`, 
  a service instance of `Yokai\SafeDelete\Usage\Finder\Adapter\Doctrine\ORM\DoctrineORMIntrospectionUsageFinder`
  will be registered


Finally, the bundle will also register some autoconfiguring rules :

- services that implement `Yokai\SafeDelete\Usage\Finder\SupportsUsageFinderInterface`
  will get the `yokai_safe_delete.usage_finder` tag
- services that implement `Yokai\SafeDelete\Usage\Descriptor\SupportsObjectDescriptorInterface`
  will get the `yokai_safe_delete.object_descriptor` tag


### Registering services manually

```yaml
# config/services.yaml

services:
    # ...
    app.safe_delete.object_descriptor.page:
        class: Yokai\SafeDelete\Usage\Descriptor\Adapter\Symfony\PropertyAccess\PropertyAccessObjectDescriptor
        arguments:
            $propertyPath: metadata.title
            $objectClass: Page

    app.safe_delete.object_descriptor.general_usage:
        class: Yokai\SafeDelete\Usage\Descriptor\Adapter\Symfony\PropertyAccess\PropertyAccessObjectDescriptor
        arguments:
            $transId: deletion.usage.description

```

> **note** thanks to the autowiring and the autoconfiguring, you've almost nothing to do.
