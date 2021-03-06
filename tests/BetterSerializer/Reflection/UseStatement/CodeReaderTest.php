<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\Reflection\UseStatement;

use League\Flysystem\Filesystem;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 *
 */
class CodeReaderTest extends TestCase
{

    /**
     *
     */
    public function testEverything(): void
    {
        $content = 'xxx';
        $dirName = stripos(PHP_OS, 'WIN')  === 0 ? 'c:\\' : '/';
        $fileName = 'file.php';

        $reflectionClass = $this->getMockBuilder(ReflectionClass::class)
            ->disableOriginalConstructor()
            ->getMock();
        $reflectionClass->method('getFileName')
            ->willReturn($dirName . $fileName);
        /* @var $reflectionClass ReflectionClass */

        $fileReader = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileReader->method('__call')
            ->with('getFirstXLines', [$fileName])
            ->willReturn($content);
        /* @var $fileReader Filesystem */

        $codeReader = new CodeReader($fileReader);
        $returned = $codeReader->readUseStatementsSource($reflectionClass);

        self::assertSame($returned, $content);
    }
}
