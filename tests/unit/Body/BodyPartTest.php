<?php

declare(strict_types=1);

namespace Tests\Postboy\Message\Body;

use Postboy\Message\Body\BodyPart;
use Postboy\Contract\Message\Body\Stream\StreamInterface;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class BodyPartTest extends BodyPartTestCase
{
    public function testBodyPart()
    {
        $stream = $this->createStream();
        $contentType = $this->createContentType();
        $body = $this->createBodyPart($stream, $contentType);
        $this->assertBodyPart($body, $stream, $contentType);
    }

    private function createBodyPart(StreamInterface $stream, string $contentType): BodyPart
    {
        return GeneratorFactory::bodyPart()->withStream($stream)->withContentType($contentType)->make();
    }
}
