<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\MetaData\Model\PropertyTuple;

use BetterSerializer\DataBind\MetaData\Model\ConstructorParamModel\ConstructorParamMetaDataInterface;
use BetterSerializer\DataBind\MetaData\Model\PropertyModel\PropertyMetaDataInterface;
use BetterSerializer\DataBind\MetaData\Type\TypeInterface;

/**
 *
 */
interface PropertyWithConstructorParamTupleInterface
{

    /**
     * @return PropertyMetaDataInterface
     */
    public function getPropertyMetaData(): PropertyMetaDataInterface;

    /**
     * @return ConstructorParamMetaDataInterface
     */
    public function getConstructorParamMetaData(): ConstructorParamMetaDataInterface;

    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface;
}
