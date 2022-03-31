<?php

declare(strict_types=1);

namespace Tests\Postboy\Message\Body\Stream;

use Postboy\Contract\Message\Body\Stream\StreamInterface;
use Postboy\Message\Body\Stream\StringStream;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class StringStreamTest extends StreamTestCase
{
    protected function createStream(string $content): StreamInterface
    {
        return GeneratorFactory::stream()->withType(StringStream::class)->withContents($content)->make();
    }
}
