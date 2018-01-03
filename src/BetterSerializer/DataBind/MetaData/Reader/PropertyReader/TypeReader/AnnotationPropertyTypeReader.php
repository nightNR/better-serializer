<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\MetaData\Reader\PropertyReader\TypeReader;

use BetterSerializer\DataBind\MetaData\Reader\PropertyReader\Context\PropertyContextInterface;
use BetterSerializer\DataBind\MetaData\Type\StringFormType\ContextStringFormTypeInterface;
use BetterSerializer\DataBind\MetaData\Type\StringFormType\Parser\StringTypeParserInterface;

/**
 * Class AnnotationPropertyTypeReader
 * @author mfris
 * @package BetterSerializer\DataBind\MetaData\Reader
 */
final class AnnotationPropertyTypeReader implements TypeReaderInterface
{

    /**
     * @var StringTypeParserInterface
     */
    private $stringTypeParser;

    /**
     * @param StringTypeParserInterface $stringTypeParser
     */
    public function __construct(StringTypeParserInterface $stringTypeParser)
    {
        $this->stringTypeParser = $stringTypeParser;
    }

    /**
     * @param PropertyContextInterface $context
     * @return ContextStringFormTypeInterface|null
     */
    public function resolveType(PropertyContextInterface $context): ?ContextStringFormTypeInterface
    {
        $propertyAnnotation = $context->getPropertyAnnotation();

        if ($propertyAnnotation === null) {
            return null;
        }

        $propertyType = $propertyAnnotation->getType();

        return $this->stringTypeParser->parseWithParentContext($propertyType, $context->getReflectionClass());
    }
}
