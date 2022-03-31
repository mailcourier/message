<?php

declare(strict_types=1);

namespace Postboy\Message\Body;

use Postboy\Contract\Message\Body\Collection\BodyCollectionInterface;
use Postboy\Contract\Message\Body\MultipartBodyInterface;
use Postboy\Contract\Message\Type\MultipartType;

class MultipartBody extends Body implements MultipartBodyInterface
{
    private BodyCollectionInterface $parts;
    private string $boundary;

    public function __construct(BodyCollectionInterface $parts, MultipartType $type, string $boundary)
    {
        $this->boundary = $boundary;
        parent::__construct($type->__toString());
        $this->parts = $parts;
    }

    final public function getBoundary(): string
    {
        return $this->boundary;
    }

    final public function getParts(): BodyCollectionInterface
    {
        return $this->parts;
    }
}
