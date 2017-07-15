<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Reader\Instantiator\Standard\ParamProcessor;

use BetterSerializer\DataBind\Reader\Context\ContextInterface;
use BetterSerializer\DataBind\Reader\Processor\ProcessorInterface;

/**
 * Class ComplexParamProcessor
 * @author mfris
 * @package BetterSerializer\DataBind\Reader\Instantiator\Standard\ParamProcessor
 */
final class ComplexParamProcessor implements ParamProcessorInterface
{

    /**
     * @var string
     */
    private $key;

    /**
     * @var ProcessorInterface
     */
    private $processor;

    /**
     * ComplexParamProcessor constructor.
     * @param string $key
     * @param ProcessorInterface $processor
     */
    public function __construct(string $key, ProcessorInterface $processor)
    {
        $this->key = $key;
        $this->processor = $processor;
    }

    /**
     * @param ContextInterface $context
     * @return mixed
     */
    public function processParam(ContextInterface $context)
    {
        $subContext = $context->readSubContext($this->key);
        $this->processor->process($subContext);

        return $subContext->getDeserialized();
    }
}