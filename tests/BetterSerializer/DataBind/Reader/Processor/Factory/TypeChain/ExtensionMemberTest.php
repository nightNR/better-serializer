<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Reader\Processor\Factory\TypeChain;

use BetterSerializer\DataBind\MetaData\Type\ExtensionTypeInterface;
use BetterSerializer\DataBind\MetaData\Type\StringFormType\Parameters\ParametersInterface;
use BetterSerializer\DataBind\Reader\Processor\ExtensionProcessor;
use BetterSerializer\Dto\Car;
use BetterSerializer\Helper\ExtensionMockFactory;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 *
 */
class ExtensionMemberTest extends TestCase
{

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testCreate(): void
    {
        $className = Car::class;
        $customHandler = ExtensionMockFactory::createTypeExcensionMock($className);
        $handlerClass = get_class($customHandler);

        $parameters = $this->createMock(ParametersInterface::class);
        $type = $this->createMock(ExtensionTypeInterface::class);
        $type->expects(self::exactly(2))
            ->method('getCustomType')
            ->willReturn($className);
        $type->expects(self::once())
            ->method('getParameters')
            ->willReturn($parameters);

        $customObjectMember = new ExtensionMember([$handlerClass]);
        $processor = $customObjectMember->create($type);

        self::assertInstanceOf(ExtensionProcessor::class, $processor);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessageRegExp /Type handler [a-zA-Z0-9_\\]+ is missing the getType method\./
     */
    public function testCreateThrowsOnInvalidHandlerClass(): void
    {
        new ExtensionMember([Car::class]);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessageRegExp /Handler for class [a-zA-Z0-9_\\]+ is already registered\./
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testCreateThrowsOnDuplicitHandlerRegistration(): void
    {
        $className = Car::class;
        $customHandler1 = ExtensionMockFactory::createTypeExcensionMock($className);
        $handlerClass1 = get_class($customHandler1);
        $customHandler2 = ExtensionMockFactory::createTypeExcensionMock($className);
        $handlerClass2 = get_class($customHandler2);

        $member = new ExtensionMember([$handlerClass1]);
        $member->addExtensionClass($handlerClass2);
    }
}
