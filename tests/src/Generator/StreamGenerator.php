<?php

declare(strict_types=1);

namespace Staff\Postboy\Message\Generator;

use InvalidArgumentException;
use Postboy\Message\Body\Stream\ResourceStream;
use Postboy\Contract\Message\Body\Stream\StreamInterface;
use Postboy\Message\Body\Stream\StringStream;
use RuntimeException;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class StreamGenerator
{
    private ?string $contents;
    private string $type = StringStream::class;

    public function withContents(string $contents): self
    {
        $that = clone $this;
        $that->contents = $contents;
        return $that;
    }

    public function withType(string $type): self
    {
        if (!in_array($type, [StringStream::class, ResourceStream::class])) {
            throw new InvalidArgumentException(sprintf('%d is not instance of %s', $type, StringStream::class));
        }
        $that = clone $this;
        $that->type = $type;
        return $that;
    }

    public function make(): StreamInterface
    {
        switch ($this->type) {
            case StringStream::class:
                $stream = new StringStream();
                break;
            case ResourceStream::class:
                $stream = new ResourceStream('php://temp');
                break;
            default:
                throw new RuntimeException(sprintf('%d is not instance of %s', $this->type, StringStream::class));
        }
        $randomizer = GeneratorFactory::randomString()
            ->withUpperLetters()
            ->withLowerLetters()
            ->withDecimals()
            ->withSpecial()
        ;
        $contents = $this->contents ?? $randomizer->withLength(rand(10, 1000))->make();
        $stream->write($contents);
        $stream->rewind();
        return $stream;
    }
}
