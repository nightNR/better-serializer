<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\MetaData\Reader\PropertyReader\TypeReader;

use BetterSerializer\DataBind\MetaData\Reader\PropertyReader\Context\PropertyContextInterface;
use BetterSerializer\DataBind\MetaData\Type\StringType\StringTypeInterface;

/**
 * Class AnnotationPropertyTypeReader
 * @author mfris
 * @package BetterSerializer\DataBind\MetaData\Reader
 */
interface TypeReaderInterface
{
    /**
     * @param PropertyContextInterface $context
     * @return StringTypeInterface|null
     */
    public function resolveType(PropertyContextInterface $context): ?StringTypeInterface;
}
