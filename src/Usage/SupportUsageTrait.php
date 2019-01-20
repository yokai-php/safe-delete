<?php

namespace Yokai\SafeDelete\Usage;

trait SupportUsageTrait
{
    /**
     * @param object      $object
     * @param string|null $subjectClass
     * @param string|null $relatedClass
     *
     * @return bool
     */
    private function isValidUsage(object $object, ?string $subjectClass, ?string $relatedClass): bool
    {
        return $object instanceof Usage
            && ($subjectClass === null || $object->getSubject() instanceof $subjectClass)
            && ($relatedClass === null || $object->getRelated() instanceof $relatedClass)
        ;
    }
}
