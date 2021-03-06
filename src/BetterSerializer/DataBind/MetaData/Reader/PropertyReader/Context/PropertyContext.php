<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\MetaData\Reader\PropertyReader\Context;

use BetterSerializer\DataBind\MetaData\Annotations\AnnotationInterface;
use BetterSerializer\DataBind\MetaData\Annotations\Groups;
use BetterSerializer\DataBind\MetaData\Annotations\Property;
use BetterSerializer\DataBind\MetaData\Annotations\PropertyInterface;
use BetterSerializer\Reflection\ReflectionClassInterface;
use BetterSerializer\Reflection\ReflectionPropertyInterface;

/**
 * Class PropertyContext
 * @author mfris
 * @package BetterSerializer\DataBind\MetaData\Reader
 */
final class PropertyContext implements PropertyContextInterface
{

    /**
     * @var ReflectionClassInterface
     */
    private $reflectionClass;

    /**
     * @var ReflectionPropertyInterface
     */
    private $reflectionProperty;

    /**
     * @var AnnotationInterface[]
     */
    private $annotations;

    /**
     * PropertyContext constructor.
     * @param ReflectionClassInterface $reflectionClass
     * @param ReflectionPropertyInterface $reflectionProperty
     * @param AnnotationInterface[] $annotations
     */
    public function __construct(
        ReflectionClassInterface $reflectionClass,
        ReflectionPropertyInterface $reflectionProperty,
        array $annotations
    ) {
        $this->reflectionClass = $reflectionClass;
        $this->reflectionProperty = $reflectionProperty;
        $this->annotations = $this->filterAndIndexAnnotations($annotations);
    }

    /**
     * @return ReflectionClassInterface
     */
    public function getReflectionClass(): ReflectionClassInterface
    {
        return $this->reflectionClass;
    }

    /**
     * @return ReflectionPropertyInterface
     */
    public function getReflectionProperty(): ReflectionPropertyInterface
    {
        return $this->reflectionProperty;
    }

    /**
     * @return AnnotationInterface[]
     */
    public function getAnnotations(): array
    {
        return $this->annotations;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->reflectionClass->getNamespaceName();
    }

    /**
     * @return PropertyInterface|null
     */
    public function getPropertyAnnotation(): ?PropertyInterface
    {
        if (!isset($this->annotations[Property::ANNOTATION_NAME])) {
            return null;
        }

        return $this->annotations[Property::ANNOTATION_NAME];
    }

    /**
     * @param array $annotations
     * @return AnnotationInterface[]
     */
    private function filterAndIndexAnnotations(array $annotations): array
    {
        $indexed = [];

        foreach ($annotations as $annotation) {
            if (!$annotation instanceof AnnotationInterface) {
                continue;
            }

            $indexed[$annotation->getAnnotationName()] = $annotation;
        }

        if (!isset($indexed[Groups::ANNOTATION_NAME])) {
            $indexed[Groups::ANNOTATION_NAME] = new Groups();
        }

        return $indexed;
    }
}
