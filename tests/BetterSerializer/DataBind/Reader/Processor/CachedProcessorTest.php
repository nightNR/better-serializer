<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Reader\Processor;

use BetterSerializer\DataBind\Reader\Context\ContextInterface;
use BetterSerializer\DataBind\Reader\Processor\Factory\Recursive\CacheInterface;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 *
 */
class CachedProcessorTest extends TestCase
{

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage This method shouldn't be called.
     */
    public function testProcessShouldThrow(): void
    {
        $key = 'test';
        $cache = $this->createMock(CacheInterface::class);
        $context = $this->createMock(ContextInterface::class);

        $cached = new CachedProcessor($cache, $key);
        $cached->process($context);
    }

    /**
     *
     */
    public function testGetProcessor(): void
    {
        $key = 'test';
        $processor = $this->createMock(ProcessorInterface::class);
        $cache = $this->createMock(CacheInterface::class);
        $cache->method('getProcessor')
            ->with($key)
            ->willReturn($processor);

        $cached = new CachedProcessor($cache, $key);

        self::assertSame($processor, $cached->getProcessor());
    }
}
