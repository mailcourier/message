<?php

declare(strict_types=1);

namespace Tests\Postboy\Message\Body;

use Postboy\Message\Body\Content;
use Postboy\Contract\Message\Body\Stream\StreamInterface;
use Postboy\Contract\Message\Type\ContentId;
use PHPUnit\Framework\Assert;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class ContentTest extends BodyPartTestCase
{
    public function testContent()
    {
        $stream = $this->createStream();
        $contentType = $this->createContentType();
        $contentId = $this->createContentId();
        $body = $this->createContent($stream, $contentId, $contentType);
        $this->assertBodyPart($body, $stream, $contentType);
        Assert::assertSame($contentId, $body->getContentId());
    }

    private function createContentId(): ContentId
    {
        return GeneratorFactory::contentId()->make();
    }

    private function createContent(StreamInterface $stream, ContentId $contentId, string $contentType): Content
    {
        return GeneratorFactory::content()
            ->withStream($stream)
            ->withContentId($contentId)
            ->withContentType($contentType)
            ->make()
            ;
    }
}
