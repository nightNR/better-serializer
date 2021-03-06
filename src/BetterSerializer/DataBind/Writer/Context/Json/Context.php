<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Writer\Context\Json;

use BetterSerializer\DataBind\Writer\Context\ContextInterface;
use RuntimeException;

/**
 * Class Context
 * @author mfris
 * @package BetterSerializer\DataBind\Writer\ValueWriter\Json
 */
final class Context implements ContextInterface
{

    /**
     * @var array|mixed
     */
    private $data = [];

    /**
     * @param $value
     */
    public function writeSimple($value): void
    {
        $this->data = $value;
    }

    /**
     * @param string|int $key
     * @param mixed $value
     * @return void
     */
    public function write($key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @return ContextInterface
     */
    public function createSubContext(): ContextInterface
    {
        return new self();
    }

    /**
     * @param mixed $key
     * @param ContextInterface $context
     * @throws RuntimeException
     */
    public function mergeSubContext($key, ContextInterface $context): void
    {
        if (!$context instanceof self) {
            throw new RuntimeException(
                sprintf(
                    'Invalid context to merge. Expected: %s, actual: %s',
                    __CLASS__,
                    get_class($context)
                )
            );
        }

        $this->data[$key] = $context->getRawData();
    }

    /**
     * @return array
     */
    public function getRawData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return json_encode($this->data);
    }
}
