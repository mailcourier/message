<?php

declare(strict_types=1);

namespace Postboy\Message\Body;

use Postboy\Contract\Message\Body\AttachmentInterface;
use Postboy\Contract\Message\Body\Stream\StreamInterface;
use Postboy\Contract\Message\Type\Filename;

class Attachment extends BodyPart implements AttachmentInterface
{
    private Filename $filename;

    final public function __construct(
        StreamInterface $stream,
        Filename $filename,
        string $contentType = 'application/octet-stream'
    ) {
        $this->filename = $filename;
        parent::__construct($stream, $contentType);
    }

    final public function getFilename(): Filename
    {
        return $this->filename;
    }
}
