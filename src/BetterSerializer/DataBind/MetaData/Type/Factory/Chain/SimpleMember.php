<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\MetaData\Type\Factory\Chain;

use BetterSerializer\DataBind\MetaData\Reader\StringTypedPropertyContextInterface;
use BetterSerializer\DataBind\MetaData\Type\BooleanType;
use BetterSerializer\DataBind\MetaData\Type\FloatType;
use BetterSerializer\DataBind\MetaData\Type\IntegerType;
use BetterSerializer\DataBind\MetaData\Type\NullType;
use BetterSerializer\DataBind\MetaData\Type\StringType;
use BetterSerializer\DataBind\MetaData\Type\TypeEnum;
use BetterSerializer\DataBind\MetaData\Type\TypeInterface;

/**
 * Class SimpleMember
 * @author mfris
 * @package BetterSerializer\DataBind\MetaData\Type\Factory\Chain
 */
final class SimpleMember extends ChainMember
{

    /**
     * @var string[]
     */
    private static $type2Instance = [
        TypeEnum::BOOLEAN => BooleanType::class,
        TypeEnum::NULL => NullType::class,
        TypeEnum::INTEGER => IntegerType::class,
        TypeEnum::FLOAT => FloatType::class,
        TypeEnum::STRING => StringType::class,
    ];

    /**
     * @param StringTypedPropertyContextInterface $context
     * @return bool
     */
    protected function isProcessable(StringTypedPropertyContextInterface $context): bool
    {
        return isset(self::$type2Instance[$context->getStringType()]);
    }

    /**
     * @param StringTypedPropertyContextInterface $context
     * @return TypeInterface
     */
    protected function createType(StringTypedPropertyContextInterface $context): TypeInterface
    {
        $className = self::$type2Instance[$context->getStringType()];

        return new $className();
    }
}
