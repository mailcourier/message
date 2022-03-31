<?php

declare(strict_types=1);

namespace Staff\Postboy\Message\Generator;

class ContentTypeGenerator
{
    private array $contentTypes = [
        'text/plain',
        'text/html',
        'text/html',
        'text/html',
        'text/css',
        'application/javascript',
        'application/json',
        'application/xml',
        'application/x-shockwave-flash',
        'video/x-flv',
        'image/png',
        'image/jpeg',
        'image/jpeg',
        'image/jpeg',
        'image/gif',
        'image/bmp',
        'image/vnd.microsoft.icon',
        'image/tiff',
        'image/tiff',
        'image/svg+xml',
        'image/svg+xml',
        'application/zip',
        'application/x-rar-compressed',
        'application/x-msdownload',
        'application/x-msdownload',
        'application/vnd.ms-cab-compressed',
        'audio/mpeg',
        'video/quicktime',
        'video/quicktime',
        'application/pdf',
        'image/vnd.adobe.photoshop',
        'application/postscript',
        'application/postscript',
        'application/postscript',
        'application/msword',
        'application/rtf',
        'application/vnd.ms-excel',
        'application/vnd.ms-powerpoint',
        'application/vnd.oasis.opendocument.text',
        'application/vnd.oasis.opendocument.spreadsheet',
    ];

    public function make(): string
    {
        return $this->contentTypes[array_rand($this->contentTypes)];
    }
}
