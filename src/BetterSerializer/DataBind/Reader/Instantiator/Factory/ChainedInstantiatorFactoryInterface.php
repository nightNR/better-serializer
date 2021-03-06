<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Reader\Instantiator\Factory;

use BetterSerializer\DataBind\MetaData\Model\MetaDataInterface;

/**
 * Interface FactoryInterface
 * @package BetterSerializer\DataBind\Reader\Instantiator\Factory
 */
interface ChainedInstantiatorFactoryInterface
{

    /**
     * @param MetaDataInterface $metaData
     * @return InstantiatorResultInterface
     */
    public function newInstantiator(MetaDataInterface $metaData): InstantiatorResultInterface;

    /**
     * @param MetaDataInterface $metaData
     * @return bool
     */
    public function isApplicable(MetaDataInterface $metaData): bool;
}
