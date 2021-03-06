<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Naming\PropertyNameTranslator;

use BetterSerializer\DataBind\MetaData\Model\PropertyModel\PropertyMetaDataInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class CamelCaseTranslatorTest extends TestCase
{

    /**
     * @param string $propertyName
     * @param string $expectedTranslated
     * @dataProvider snakeCaseData
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\MockObject\RuntimeException
     * @throws \ReflectionException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testTranslate(string $propertyName, string $expectedTranslated): void
    {
        $propertyMetaData = $this->createMock(PropertyMetaDataInterface::class);
        $propertyMetaData->expects(self::once())
            ->method('getName')
            ->willReturn($propertyName);

        $translator = new CamelCaseTranslator();
        $translated = $translator->translate($propertyMetaData);

        self::assertEquals($expectedTranslated, $translated);
    }

    /**
     * @return array
     */
    public function snakeCaseData(): array
    {
        return [
            ['camel_case_test', 'camelCaseTest'],
            ['camel_Case_Test', 'camelCaseTest'],
            ['snake__Case__Test', 'snakeCaseTest'],
        ];
    }
}
