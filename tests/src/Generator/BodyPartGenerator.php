<?php

declare(strict_types=1);

namespace Staff\Postboy\Message\Generator;

use Postboy\Message\Body\BodyPart;
use Postboy\Contract\Message\Body\Stream\StreamInterface;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class BodyPartGenerator
{
    private ?StreamInterface $stream;
    private ?string $contentType = null;

    public function withStream(StreamInterface $stream): self
    {
        $that = clone $this;
        $that->stream = $stream;
        return $that;
    }

    public function withContentType(string $contentType): self
    {
        $that = clone $this;
        $that->contentType = $contentType;
        return $that;
    }

    public function make(): BodyPart
    {
        $stream = $this->stream ?? GeneratorFactory::stream()->make();
        $contentType = $this->contentType ?? GeneratorFactory::contentType()->make();
        return new BodyPart($stream, $contentType);
    }
}
