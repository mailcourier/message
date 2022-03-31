<?php

declare(strict_types=1);

namespace Tests\Postboy\Message\Body\Stream;

use Postboy\Message\Body\Stream\ResourceStream;
use Postboy\Contract\Message\Body\Stream\StreamInterface;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class ResourceStreamTest extends StreamTestCase
{
    protected function createStream(string $content): StreamInterface
    {
        return GeneratorFactory::stream()->withType(ResourceStream::class)->withContents($content)->make();
    }
}
