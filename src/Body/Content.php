<?php

declare(strict_types=1);

namespace Postboy\Message\Body;

use Postboy\Contract\Message\Body\ContentInterface;
use Postboy\Contract\Message\Body\Stream\StreamInterface;
use Postboy\Contract\Message\Type\ContentId;

class Content extends BodyPart implements ContentInterface
{
    private ContentId $contentId;

    final public function __construct(
        StreamInterface $stream,
        ContentId $filename,
        string $contentType = 'application/octet-stream'
    ) {
        $this->contentId = $filename;
        parent::__construct($stream, $contentType);
    }

    final public function getContentId(): ContentId
    {
        return $this->contentId;
    }
}
