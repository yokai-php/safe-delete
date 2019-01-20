<?php

namespace Yokai\SafeDelete\Usage\Descriptor\Adapter\Symfony\Translator;

use Symfony\Contracts\Translation\TranslatorInterface;
use Yokai\SafeDelete\Usage\Descriptor\ObjectDescriptorAwareInterface;
use Yokai\SafeDelete\Usage\Descriptor\ObjectDescriptorAwareTrait;
use Yokai\SafeDelete\Usage\Descriptor\SupportsObjectDescriptorInterface;
use Yokai\SafeDelete\Usage\SupportUsageTrait;
use Yokai\SafeDelete\Usage\Usage;

class TranslationUsageDescriptor implements SupportsObjectDescriptorInterface, ObjectDescriptorAwareInterface
{
    use SupportUsageTrait, ObjectDescriptorAwareTrait;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var string
     */
    private $transId;

    /**
     * @var string|null
     */
    private $transDomain;

    /**
     * @var string|null
     */
    private $subjectObjectClass;

    /**
     * @var string|null
     */
    private $relatedObjectClass;

    /**
     * @param TranslatorInterface $translator
     * @param string              $transId
     * @param string|null         $transDomain
     * @param string|null         $subjectObjectClass
     * @param string|null         $relatedObjectClass
     */
    public function __construct(
        TranslatorInterface $translator,
        string $transId,
        string $transDomain = null,
        string $subjectObjectClass = null,
        string $relatedObjectClass = null
    ) {
        $this->translator = $translator;
        $this->transId = $transId;
        $this->transDomain = $transDomain;
        $this->subjectObjectClass = $subjectObjectClass;
        $this->relatedObjectClass = $relatedObjectClass;
    }

    /**
     * @inheritdoc
     */
    public function supports(object $object): bool
    {
        return $this->isValidUsage($object, $this->subjectObjectClass, $this->relatedObjectClass);
    }

    /**
     * @inheritdoc
     */
    public function describe(object $object): string
    {
        if (!$object instanceof Usage) {
            throw new \BadMethodCallException();
        }

        return $this->translator->trans(
            $this->transId,
            [
                '%subject%' => $this->safelyDescribe($object->getSubject()),
                '%relation%' => $this->safelyDescribe($object->getRelation()),
                '%related%' => $this->safelyDescribe($object->getRelated()),
            ]
            ,
            $this->transDomain
        );
    }

    private function safelyDescribe(object $object): ?string
    {
        try {
            return $this->objectDescriptor->describe($object);
        } catch (\Exception $exception) {
        }

        return null;
    }
}
