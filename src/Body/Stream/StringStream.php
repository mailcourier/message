<?php

declare(strict_types=1);

namespace Postboy\Message\Body\Stream;

use Postboy\Contract\Message\Body\Stream\StreamInterface;

class StringStream implements StreamInterface
{
    private string $source;
    private int $cursor = 0;
    private int $length;

    final public function __construct(string $source = '')
    {
        $this->source = $source;
        $this->length = strlen($source);
        $this->rewind();
    }

    final public function eof(): bool
    {
        return $this->cursor >= $this->length;
    }

    final public function read(int $length): string
    {
        $left = $this->length - $this->cursor;
        $size = min($length, $left);
        if ($size === 0) {
            return '';
        }
        $chunk = substr($this->source, $this->cursor, $size);
        if (empty($chunk)) {
            return '';
        }
        $this->cursor += $size;
        return $chunk;
    }

    final public function write(string $data): void
    {
        $length = strlen($data);
        $this->source = substr_replace($this->source, $data, $this->cursor, $length);
        $this->length = strlen($this->source);
        $this->cursor += $length;
    }

    final public function rewind(): void
    {
        $this->cursor = 0;
    }
}
