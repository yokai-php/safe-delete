<?php

namespace Yokai\SafeDelete\Usage;

class Usage
{
    /**
     * @var object
     */
    private $subject;

    /**
     * @var Relation
     */
    private $relation;

    /**
     * @var object
     */
    private $related;

    /**
     * @param object   $subject
     * @param Relation $relation
     * @param object   $related
     */
    public function __construct(object $subject, Relation $relation, object $related)
    {
        $this->subject = $subject;
        $this->relation = $relation;
        $this->related = $related;
    }

    /**
     * @return object
     */
    public function getSubject(): object
    {
        return $this->subject;
    }

    /**
     * @return Relation
     */
    public function getRelation(): Relation
    {
        return $this->relation;
    }

    /**
     * @return object
     */
    public function getRelated(): object
    {
        return $this->related;
    }
}
