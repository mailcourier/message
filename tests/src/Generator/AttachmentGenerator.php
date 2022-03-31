<?php

declare(strict_types=1);

namespace Staff\Postboy\Message\Generator;

use Postboy\Message\Body\Attachment;
use Postboy\Contract\Message\Body\Stream\StreamInterface;
use Postboy\Contract\Message\Type\Filename;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class AttachmentGenerator
{
    private ?StreamInterface $stream;
    private ?Filename $filename;
    private ?string $contentType = null;

    public function withStream(StreamInterface $stream): self
    {
        $that = clone $this;
        $that->stream = $stream;
        return $that;
    }

    public function withFilename(Filename $filename): self
    {
        $that = clone $this;
        $that->filename = $filename;
        return $that;
    }

    public function withContentType(string $contentType): self
    {
        $that = clone $this;
        $that->contentType = $contentType;
        return $that;
    }

    public function make(): Attachment
    {
        $stream = $this->stream ?? GeneratorFactory::stream()->make();
        $contentType = $this->contentType ?? GeneratorFactory::contentType()->make();
        $filename = $this->filename ?? GeneratorFactory::filename()->make();
        return new Attachment($stream, $filename, $contentType);
    }
}
