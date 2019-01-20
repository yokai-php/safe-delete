Doctrine ORM integration
------------------------

The `doctrine/orm` library is an object-relational mapper (ORM) that provides transparent persistence for PHP objects.


### Usage Finder

The [DoctrineORMIntrospectionUsageFinder](../../src/Usage/Finder/Adapter/Doctrine/ORM/DoctrineORMIntrospectionUsageFinder.php)
uses Doctrine ORM metadata and finds related entities to the resource you are about to delete.

With the following mapping :

```php
<?php

/**
 * @ORM\Entity()
 */
class Product
{
    /**
     * @ORM\ManyToOne(targetEntity="Product")
     */
    public $soldWith;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    public $parent;

    /**
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumn(onDelete="SET NULL", nullable=true)
     */
    public $replaces;

    /**
     * @ORM\ManyToMany(targetEntity="Product")
     */
    public $crossSell;
}
```

Asking for usages of a `Product` instance can retrieve :
- `Product` the product is *sold with* of, with `Relation::RESTRICT` link type
- `Product` the product is *parent* of, with `Relation::DELETE` link type
- `Product` the product *replaces*, with `Relation::UNLINK` link type
- `Product` the product *cross sells*, with `Relation::DELETE` link type



---

« [README](../../README.md)
