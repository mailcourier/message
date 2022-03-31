<?php

declare(strict_types=1);

namespace Tests\Postboy\Message\Body;

use Postboy\Message\Body\Attachment;
use Postboy\Contract\Message\Body\Stream\StreamInterface;
use Postboy\Contract\Message\Type\Filename;
use PHPUnit\Framework\Assert;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class AttachmentTest extends BodyPartTestCase
{
    public function testAttachment()
    {
        $stream = $this->createStream();
        $contentType = $this->createContentType();
        $filename = $this->createFilename();
        $body = $this->createAttachment($stream, $filename, $contentType);
        $this->assertBodyPart($body, $stream, $contentType);
        Assert::assertSame($filename, $body->getFilename());
    }

    private function createFilename(): Filename
    {
        return GeneratorFactory::filename()->make();
    }

    private function createAttachment(StreamInterface $stream, Filename $filename, string $contentType): Attachment
    {
        return GeneratorFactory::attachment()
            ->withStream($stream)
            ->withFilename($filename)
            ->withContentType($contentType)
            ->make()
        ;
    }
}
