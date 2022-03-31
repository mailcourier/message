<?php

declare(strict_types=1);

namespace Postboy\Message\Body;

use Postboy\Contract\Message\Body\BodyInterface;

abstract class Body implements BodyInterface
{
    private string $contentType;

    public function __construct(string $contentType)
    {
        $this->contentType = $contentType;
    }

    final public function getContentType(): string
    {
        return $this->contentType;
    }
}
