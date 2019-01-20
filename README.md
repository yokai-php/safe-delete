Yokai Safe Delete
=================

[![Build Status](https://travis-ci.org/yokai-php/safe-delete.svg?branch=master)](https://travis-ci.org/yokai-php/safe-delete)

todo badges

Introduction
------------

This library aims to provide a way to check whether or not it is safe to delete resources in any PHP application.

This goal is achieved by checking if the resource is used by any other resource.


Documentation
-------------

Start reading the library documentation.

* [Installation](docs/1-install.md)
* [Concepts](docs/2-concepts.md) (**highly recommended**)
* [Usage](docs/3-usage.md)


Learn more about core components.

* [Usage Finder](docs/components/usage-finder.md)
* [Object Descriptor](docs/components/object-descriptor.md)



Or jump to integrations.

| Require                    | Purpose                                                        | Documentation                                        |
| -------------------------- | -------------------------------------------------------------- | ---------------------------------------------------- |
| `doctrine/orm`             | Check for usages between entities using metadata introspection | [here](docs/integration/doctrine-orm.md)             |
| `symfony/translation`      | Describe usages with translation                               | [here](docs/integration/symfony-translation.md)      |
| `symfony/property-access`  | Describe resources with property path                          | [here](docs/integration/symfony-property-access.md)  |
| `symfony/framework-bundle` | Framework integration                                          | [here](docs/integration/symfony-framework.md)        |


If you did not find what you was looking for ? Have a look to the recipes.

* [Custom Usage Finder](docs/recipes/custom-usage-finder.md)
* [Custom Object Descriptor](docs/recipes/custom-object-descriptor.md)


MIT License
-----------

License can be found [here](LICENSE).


Authors
-------

The library was originally created by [Yann Eugoné](https://github.com/yann-eugone).
See the list of [contributors](https://github.com/yokai-php/safe-delete/contributors).


---

Thank's to [Prestaconcept](https://github.com/prestaconcept) for supporting this library.
