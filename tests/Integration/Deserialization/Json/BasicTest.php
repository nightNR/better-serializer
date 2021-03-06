<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace Integration\Deserialization\Json;

use BetterSerializer\Common\SerializationType;
use BetterSerializer\Dto\Aliases;
use BetterSerializer\Dto\Car;
use BetterSerializer\Dto\Car2;
use BetterSerializer\Dto\Category;
use BetterSerializer\Dto\Nested\CarFactory;
use Integration\AbstractIntegrationTest;
use DateTimeImmutable;
use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\ExpectationFailedException;
use Pimple\Exception\UnknownIdentifierException;
use RuntimeException;
use SebastianBergmann\RecursionContext\InvalidArgumentException as RecursionInvalidArgumentException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class BasicTest extends AbstractIntegrationTest
{

    /**
     * @dataProvider getTestData
     * @group integration
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @param string $expectedJson
     * @param string $stringType
     * @throws UnknownIdentifierException
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws RuntimeException
     * @throws RecursionInvalidArgumentException
     */
    public function testDeserialization(string $expectedJson, string $stringType): void
    {
        $serializer = $this->getSerializer();

        $data = $serializer->deserialize($expectedJson, $stringType, SerializationType::JSON());
        $json = $serializer->serialize($data, SerializationType::JSON());

        self::assertSame($expectedJson, $json);
    }

    /**
     * @dataProvider getTestData
     * @group integration
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @param string $expectedJson
     * @param string $stringType
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws UnknownIdentifierException
     * @throws RuntimeException
     * @throws RecursionInvalidArgumentException
     */
    public function testDeserializationCached(string $expectedJson, string $stringType): void
    {
        $serializer = $this->getCachedSerializer();

        $data = $serializer->deserialize($expectedJson, $stringType, SerializationType::JSON());
        $json = $serializer->serialize($data, SerializationType::JSON());

        self::assertSame($expectedJson, $json);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getTestData(): array
    {
        return [
            $this->getNestedObjectTuple(),
            $this->getNestedObjectWithArrayTuple(),
            $this->getObjectsInArrayTuple(),
            $this->getObjectsInArrayTupleWithInnerArray(),
            $this->getStringsInArray(),
            $this->getOverridenNameTuple(),
            $this->getNamespaceFeatureTupleWithDateTimes(),
            $this->getRecursiveDataTuple(),
            $this->getPrimitiveDataTuple(),
            $this->getAliasesTuple(),
        ];
    }

    /**
     * @return array
     */
    private function getNestedObjectTuple(): array
    {
        $json = '{"title":"Honda","color":"white","radio":{"brand":"test station"},"doors":[]}';

        return [$json, Car::class];
    }

    /**
     * @return array
     */
    private function getNestedObjectWithArrayTuple(): array
    {
        $json = '{"title":"Honda","color":"white","radio":{"brand":"test station"},'
            . '"doors":[{"parentalLock":false},{"parentalLock":false}]}';

        return [$json, Car::class];
    }

    /**
     * @return array
     */
    private function getObjectsInArrayTuple(): array
    {
        $jsonArray = [];

        for ($i = 0; $i < 2; $i++) {
            $jsonArray[] = '{"title":"Honda","color":"white","radio":{"brand":"test station"},"doors":[]}';
        }

        $json = '[' . implode(',', $jsonArray) . ']';

        return [$json, 'array<' . Car::class .'>'];
    }

    /**
     * @return array
     */
    private function getObjectsInArrayTupleWithInnerArray(): array
    {
        $jsonArray = [];

        for ($i = 0; $i < 2; $i++) {
            $jsonArray[] = '{"title":"Honda","color":"white","radio":{"brand":"test station"},'
                . '"doors":[{"parentalLock":false},{"parentalLock":false}]}';
        }

        $json = '[' . implode(',', $jsonArray) . ']';

        return [$json, 'array<' . Car::class .'>'];
    }

    /**
     * @return array
     */
    private function getStringsInArray(): array
    {
        $jsonArray = [];

        for ($i = 0; $i < 2; $i++) {
            $jsonArray[] = '"test"';
        }

        $json = '[' . implode(',', $jsonArray) . ']';

        return [$json, 'array<string>'];
    }

    /**
     * @return array
     */
    private function getOverridenNameTuple(): array
    {
        $json = '{"serializedTitle":"testTitle","manufactured":"2010-09-01 08:07:06",'
            . '"selled":"2017-08-19T17:31:09+00:00","serviced":"2017-08-19T17:31:09+00:00","dismantled":null}';

        return [$json, Car2::class];
    }

    /**
     * @return array
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    private function getNamespaceFeatureTupleWithDateTimes(): array
    {
        $carJson = '{"title":"Honda","color":"white","radio":{"brand":"test station"},"doors":[],"special":"special"}';
        $car2Json = '{"serializedTitle":"testTitle","manufactured":"2010-09-01 08:07:06",'
            . '"selled":"2017-08-19T17:31:09+00:00","serviced":"2017-08-19T17:31:09+00:00","dismantled":null}';
        $json = '{"cars":[' . $carJson .'],"cars2":['. $car2Json .']}';

        return [$json, CarFactory::class];
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getRecursiveDataTuple(): array
    {
        $dateTime = (new DateTimeImmutable())->format(DateTime::ATOM);

        $categoryJson = '{"id":2,"parent":{"id":1,"parent":null,"children":[],"createdAt":"' . $dateTime
            . '","updatedAt":null},"children":[],"createdAt":"' . $dateTime . '","updatedAt":null}';

        return [$categoryJson, Category::class];
    }

    /**
     * @return array
     */
    private function getPrimitiveDataTuple(): array
    {
        return [6, 'int'];
    }

    /**
     * @return array
     */
    private function getAliasesTuple(): array
    {
        $aliasesArray = [
            'integer1' => 1,
            'integer2' => 2,
        ];
        $json = json_encode($aliasesArray);

        return [$json, Aliases::class];
    }
}
