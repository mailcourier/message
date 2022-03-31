<?php

declare(strict_types=1);

namespace Postboy\Message\Body;

use Postboy\Contract\Message\Body\BodyPartInterface;
use Postboy\Contract\Message\Body\Stream\StreamInterface;

class BodyPart extends Body implements BodyPartInterface
{
    private StreamInterface $stream;

    public function __construct(StreamInterface $stream, string $contentType)
    {
        parent::__construct($contentType);
        $this->stream = $stream;
    }

    final public function getStream(): StreamInterface
    {
        return $this->stream;
    }
}
