<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer;

use BetterSerializer\Cache\Factory;
use Doctrine\Common\Cache\Cache;
use Pimple\Container;
use Pimple\Exception\UnknownIdentifierException;
use RuntimeException;

/**
 * Class Builder
 * @author mfris
 * @package BetterSerializer
 */
final class Builder
{

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Factory
     */
    private $cacheFactory;

    /**
     * Builder constructor.
     */
    public function __construct()
    {
        $this->initContainer();
    }

    /**
     * @return Serializer
     * @throws UnknownIdentifierException
     */
    public function createSerializer(): Serializer
    {
        return $this->container->offsetGet(Serializer::class);
    }

    /**
     *
     */
    public function enableApcuCache(): void
    {
        $this->getCacheFactory()->enableApcuCache();
    }

    /**
     * @param string $directory
     * @throws RuntimeException
     */
    public function setCacheDir(string $directory): void
    {
        $this->getCacheFactory()->setCacheDir($directory);
    }

    /**
     *
     */
    public function clearCache(): void
    {
        $this->container[Cache::class]->deleteAll();
    }

    /**
     *
     */
    private function initContainer(): void
    {
        $this->container = require dirname(__DIR__) . '/../config/di.pimple.php';
    }

    /**
     * @return Factory
     */
    private function getCacheFactory(): Factory
    {
        if (!$this->cacheFactory) {
            $this->cacheFactory = $this->container[Factory::class];
        }

        return $this->cacheFactory;
    }
}
