<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Writer\Processor;

use BetterSerializer\DataBind\Converter\ConverterInterface;
use BetterSerializer\DataBind\Writer\Context\ContextInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class SimpleCollectionProcessorTest extends TestCase
{

    /**
     *
     */
    public function testProcess(): void
    {
        $key1 = 0;
        $key2 = 1;

        $arrayData = [
            $key1 => 'test',
            $key2 => 'test2',
        ];

        $contextMock = $this->getMockBuilder(ContextInterface::class)->getMock();
        $contextMock->expects(self::exactly(2))
            ->method('write')
            ->withConsecutive([$key1, $arrayData[$key1]], [$key2, $arrayData[$key2]]);

        $converterMock = $this->getMockBuilder(ConverterInterface::class)->getMock();
        $converterMock->expects(self::exactly(2))
            ->method('convert')
            ->withConsecutive([$arrayData[$key1]], [$arrayData[$key2]])
            ->willReturnOnConsecutiveCalls($arrayData[$key1], $arrayData[$key2]);

        /* @var $contextMock ContextInterface */
        /* @var $processorMock ProcessorInterface */
        /* @var $converterMock ConverterInterface */
        $processor = new SimpleCollectionProcessor($converterMock);
        $processor->process($contextMock, $arrayData);
    }

    /**
     *
     */
    public function testProcessEmpty(): void
    {
        $arrayData = [];

        $contextMock = $this->getMockBuilder(ContextInterface::class)->getMock();
        $contextMock->expects(self::exactly(0))
            ->method('write');

        $converterMock = $this->getMockBuilder(ConverterInterface::class)->getMock();

        /* @var $contextMock ContextInterface */
        /* @var $processorMock ProcessorInterface */
        /* @var $converterMock ConverterInterface */
        $processor = new SimpleCollectionProcessor($converterMock);
        $processor->process($contextMock, $arrayData);
    }
}
