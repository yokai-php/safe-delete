<?php

namespace Yokai\SafeDelete\Usage;

class Relation
{
    public const ALL = [
        self::RESTRICT,
        self::UNLINK,
        self::DELETE,
    ];
    public const BLOCKING = [
        self::RESTRICT,
    ];
    public const NON_BLOCKING = [
        self::UNLINK,
        self::DELETE,
    ];
    public const RESTRICT = 'restrict';
    public const UNLINK = 'unlink';
    public const DELETE = 'delete';

    /**
     * @var self[]
     */
    private static $instances = [];

    /**
     * @var string
     */
    private $relatedType;

    /**
     * @var string
     */
    private $property;

    /**
     * @var string
     */
    private $relationType;

    /**
     * @param string $relatedType
     * @param string $property
     * @param string $relationType
     */
    private function __construct(string $relatedType, string $property, string $relationType)
    {
        $this->relatedType = $relatedType;
        $this->property = $property;
        $this->relationType = $relationType;
    }

    /**
     * @param string $relatedType
     * @param string $property
     * @param string $relationType
     *
     * @return Relation
     */
    public static function get(string $relatedType, string $property, string $relationType): self
    {
        $key = "$relatedType:$property";

        return self::$instances[$key] ?? self::$instances[$key] = new self($relatedType, $property, $relationType);
    }

    /**
     * @return string
     */
    public function getRelatedType(): string
    {
        return $this->relatedType;
    }

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @return string
     */
    public function getRelationType(): string
    {
        return $this->relationType;
    }
}
