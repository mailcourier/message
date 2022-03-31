<?php

declare(strict_types=1);

namespace Staff\Postboy\Message\Generator;

use Postboy\Message\Body\Content;
use Postboy\Contract\Message\Body\Stream\StreamInterface;
use Postboy\Contract\Message\Type\ContentId;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class ContentGenerator
{
    private ?StreamInterface $stream;
    private ?ContentId $contentId;
    private ?string $contentType = null;

    public function withStream(StreamInterface $stream): self
    {
        $that = clone $this;
        $that->stream = $stream;
        return $that;
    }

    public function withContentId(ContentId $contentId): self
    {
        $that = clone $this;
        $that->contentId = $contentId;
        return $that;
    }

    public function withContentType(string $contentType): self
    {
        $that = clone $this;
        $that->contentType = $contentType;
        return $that;
    }

    public function make(): Content
    {
        $stream = $this->stream ?? GeneratorFactory::stream()->make();
        $contentType = $this->contentType ?? GeneratorFactory::contentType()->make();
        $contentId = $this->contentId ?? GeneratorFactory::contentId()->make();
        return new Content($stream, $contentId, $contentType);
    }
}
