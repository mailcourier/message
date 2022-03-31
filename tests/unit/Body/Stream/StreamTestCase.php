<?php

declare(strict_types=1);

namespace Tests\Postboy\Message\Body\Stream;

use Postboy\Contract\Message\Body\Stream\StreamInterface;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

abstract class StreamTestCase extends TestCase
{
    final public function testRead()
    {
        $length = rand(100, 10000);
        $contents = GeneratorFactory::randomString()
            ->withLowerLetters()
            ->withUpperLetters()
            ->withSpecial()
            ->withSpace()
            ->withLength($length)
            ->make()
        ;
        $stream = $this->createStream($contents);
        $stream->rewind();
        Assert::assertSame($contents, $stream->read($length));
        Assert::assertSame('', $stream->read(1));

        $stream->rewind();
        $actual = '';
        while (!$stream->eof()) {
            $actual .= $stream->read(1);
        }
        Assert::assertSame($contents, $actual);
        Assert::assertSame('', $stream->read(1));
        unset($stream);
    }

    abstract protected function createStream(string $content): StreamInterface;
}
