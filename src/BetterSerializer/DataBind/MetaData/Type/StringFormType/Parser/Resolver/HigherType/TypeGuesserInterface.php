<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\MetaData\Type\StringFormType\Parser\Resolver\HigherType;

use BetterSerializer\DataBind\MetaData\Type\StringFormType\Parser\Resolver\ContextInterface;

/**
 *
 */
interface TypeGuesserInterface
{

    /**
     * @param string $potentialHigherType
     * @param ContextInterface $context
     * @return string
     */
    public function guess(string $potentialHigherType, ContextInterface $context): string;
}
