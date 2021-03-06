<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Reader\Processor;

use BetterSerializer\DataBind\Converter\ConverterInterface;
use BetterSerializer\DataBind\Reader\Context\ContextInterface;
use BetterSerializer\DataBind\Reader\Injector\InjectorInterface;
use BetterSerializer\Dto\CarInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class SimplePropertyProcessorTest extends TestCase
{

    /**
     *
     */
    public function testProcess(): void
    {
        $instance = $this->getMockBuilder(CarInterface::class)->getMock();
        $injectedValue = 5;
        $inputKey = 'test';

        $contextMock = $this->getMockBuilder(ContextInterface::class)->getMock();
        $contextMock->expects(self::once())
                    ->method('getValue')
                    ->with($inputKey)
                    ->willReturn($injectedValue);
        $contextMock->expects(self::once())
            ->method('getDeserialized')
            ->willReturn($instance);

        $injectorMock = $this->getMockBuilder(InjectorInterface::class)->getMock();
        $injectorMock->expects(self::once())
                      ->method('inject')
                      ->with($instance, $injectedValue);

        $converterMock = $this->getMockBuilder(ConverterInterface::class)->getMock();
        $converterMock->expects(self::once())
                      ->method('convert')
                      ->with($injectedValue)
                      ->willReturn($injectedValue);

        /* @var $injectorMock InjectorInterface */
        /* @var $converterMock ConverterInterface */
        /* @var $contextMock ContextInterface */
        $processor = new SimplePropertyProcessor($injectorMock, $converterMock, $inputKey);
        $processor->process($contextMock);
    }
}
