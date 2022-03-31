<?php

declare(strict_types=1);

namespace Postboy\Message\Body\Stream;

use Postboy\Contract\Message\Body\Stream\StreamInterface;

class ResourceStream implements StreamInterface
{
    /** @var resource */
    private $resource;

    final public function __construct(string $source)
    {
        $this->resource = fopen($source, 'cb+');
        $this->rewind();
    }

    final public function eof(): bool
    {
        return feof($this->resource);
    }

    final public function read(int $length): string
    {
        $result = fread($this->resource, $length);
        if (!is_string($result)) {
            return '';
        }
        return $result;
    }

    final public function write(string $data): void
    {
        fwrite($this->resource, $data);
    }

    final public function rewind(): void
    {
        rewind($this->resource);
    }

    final public function __destruct()
    {
        fclose($this->resource);
    }
}
