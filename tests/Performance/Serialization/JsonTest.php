<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace Performance\Serialization;

use BetterSerializer\Builder;
use BetterSerializer\Common\SerializationType;
use BetterSerializer\Dto\Car;
use BetterSerializer\Dto\Door;
use BetterSerializer\Dto\Radio;
use PHPUnit\Framework\TestCase;
use JMS\Serializer\SerializerBuilder;

/**
 * Class Json
 * @author mfris
 * @package Integration\Serialization
 */
final class JsonTest extends TestCase
{

    /**
     * @group performance
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testSerialization(): void
    {
        $this->markTestIncomplete('Implement caching to see difference.');
        $expectedJson = '{"title":"Honda","color":"white","radio":{"brand":"test station"},"doors":[]}';

        $builder = new Builder();
        $serializer = $builder->createSerializer();
        $jmsSerializer = SerializerBuilder::create()->build();

        $radio = new Radio('test station');
        $car = new Car('Honda', 'white', $radio);

        // opcache warmup
        $jmsSerializer->serialize($car, 'json');
        $serializer->writeValueAsString($car, SerializationType::JSON());

        $start = microtime(true);
        $json = $serializer->writeValueAsString($car, SerializationType::JSON());
        $betterMicro = (microtime(true) - $start);
        self::assertSame($expectedJson, $json);

        $start = microtime(true);
        $jmsJson = $jmsSerializer->serialize($car, 'json');
        $jmsMicro = (microtime(true) - $start);
        self::assertSame($expectedJson, $jmsJson);
        self::assertGreaterThan($betterMicro, $jmsMicro);
    }

    /**
     * @group performance
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testSerializationBigArray(): void
    {
        $builder = new Builder();
        $serializer = $builder->createSerializer();
        $jmsSerializer = SerializerBuilder::create()->build();

        $radio = new Radio('test station');
        $car = new Car('Honda', 'white', $radio);

        $data = [];
        $json = [];

        for ($i = 0; $i < 2000; $i++) {
            $data[] = $car;
            $json[] = '{"title":"Honda","color":"white","radio":{"brand":"test station"},"doors":[]}';
        }

        $expectedJson = '[' . implode(',', $json) . ']';

        // opcache warmup
        $jmsSerializer->serialize($data, 'json');
        $serializer->writeValueAsString($data, SerializationType::JSON());

        $start = microtime(true);
        $jmsJson = $jmsSerializer->serialize($data, 'json');
        $jmsMicro = (microtime(true) - $start);
        self::assertSame($expectedJson, $jmsJson);

        $start = microtime(true);
        $json = $serializer->writeValueAsString($data, SerializationType::JSON());
        $betterMicro = (microtime(true) - $start);
        self::assertSame($expectedJson, $json);
        // echo PHP_EOL . $jmsMicro . '-' . $betterMicro;
        self::assertGreaterThan(5.5, $jmsMicro / $betterMicro);
    }

    /**
     * @group performance
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testSerializationBigArrayWithNestedArray(): void
    {
        $builder = new Builder();
        $serializer = $builder->createSerializer();
        $jmsSerializer = SerializerBuilder::create()->build();

        $radio = new Radio('test station');
        $door = new Door();
        $doors = [$door, $door];
        $car = new Car('Honda', 'white', $radio, $doors);

        $data = [];
        $json = [];

        for ($i = 0; $i < 2000; $i++) {
            $data[] = $car;
            $json[] = '{"title":"Honda","color":"white","radio":{"brand":"test station"},'
                . '"doors":[{"parentalLock":false},{"parentalLock":false}]}';
        }

        $expectedJson = '[' . implode(',', $json) . ']';

        // opcache warmup
        $jmsSerializer->serialize($data, 'json');
        $serializer->writeValueAsString($data, SerializationType::JSON());

        $start = microtime(true);
        $jmsJson = $jmsSerializer->serialize($data, 'json');
        $jmsMicro = (microtime(true) - $start);
        self::assertSame($expectedJson, $jmsJson);

        $start = microtime(true);
        $json = $serializer->writeValueAsString($data, SerializationType::JSON());
        $betterMicro = (microtime(true) - $start);
        self::assertSame($expectedJson, $json);
        // echo PHP_EOL . $jmsMicro . '-' . $betterMicro;
        self::assertGreaterThan(6.5, $jmsMicro / $betterMicro);
    }
}