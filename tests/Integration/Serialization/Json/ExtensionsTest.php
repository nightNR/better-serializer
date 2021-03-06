<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace Integration\Serialization\Json;

use BetterSerializer\Common\SerializationType;
use BetterSerializer\Dto\Car;
use BetterSerializer\Dto\Car2;
use BetterSerializer\Dto\Car3;
use BetterSerializer\Dto\Category;
use BetterSerializer\Dto\Door;
use BetterSerializer\Dto\Nested\CarFactory;
use BetterSerializer\Dto\Radio;
use BetterSerializer\Dto\SpecialCar;
use Doctrine\Common\Collections\ArrayCollection;
use Integration\AbstractIntegrationTest;
use DateTime;
use DateTimeImmutable;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class ExtensionsTest extends AbstractIntegrationTest
{

    /**
     * @dataProvider getTestTuples
     * @group integration
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @param mixed $data
     * @param string $expectedJson
     * @throws \LogicException
     * @throws \ReflectionException
     * @throws \RuntimeException
     */
    public function testSerialization($data, string $expectedJson): void
    {
        $serializer = $this->getSerializer();

        $json = $serializer->serialize($data, SerializationType::JSON());
        self::assertSame($expectedJson, $json);
    }

    /**
     * @dataProvider getTestTuples
     * @group integration
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @param mixed $data
     * @param string $expectedJson
     * @throws \LogicException
     * @throws \ReflectionException
     * @throws \RuntimeException
     */
    public function testSerializationCached($data, string $expectedJson): void
    {
        $serializer = $this->getCachedSerializer();

        $json = $serializer->serialize($data, SerializationType::JSON());
        self::assertSame($expectedJson, $json);
    }

    /**
     * @return array
     */
    public function getTestTuples(): array
    {
        return [
            $this->getCustomExtensionTuple(),

        ];
    }

    /**
     * @return array
     */
    private function getCustomExtensionTuple(): array
    {
        $door1 = new Door();
        $door2 = new Door(true);
        $doors = new ArrayCollection([$door1, $door2]);

        $car = new Car3($doors);
        $json = '{"doors":[{"parentalLock":false},{"parentalLock":true}],"isForKids":"yes"}';

        return [$car, $json];
    }
}
