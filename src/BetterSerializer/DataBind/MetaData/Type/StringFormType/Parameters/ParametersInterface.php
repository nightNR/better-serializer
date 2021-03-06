<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\MetaData\Type\StringFormType\Parameters;

use Countable;

/**
 *
 */
interface ParametersInterface extends Countable
{

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * @param string $name
     * @return ParameterInterface
     */
    public function get(string $name): ParameterInterface;

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @param ParametersInterface $parameters
     * @return bool
     */
    public function equals(ParametersInterface $parameters): bool;

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @return string
     */
    public function __toString(): string;
}
