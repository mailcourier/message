<?php

declare(strict_types=1);

namespace Staff\Postboy\Message\Generator\Factory;

use Staff\Postboy\Message\Generator\AttachmentGenerator;
use Staff\Postboy\Message\Generator\BodyPartGenerator;
use Staff\Postboy\Message\Generator\ContentGenerator;
use Staff\Postboy\Message\Generator\ContentIdGenerator;
use Staff\Postboy\Message\Generator\ContentTypeGenerator;
use Staff\Postboy\Message\Generator\FilenameGenerator;
use Staff\Postboy\Message\Generator\RandomStringGenerator;
use Staff\Postboy\Message\Generator\StreamGenerator;

class GeneratorFactory
{
    private static array $generators = [];

    public static function stream(): StreamGenerator
    {
        $key = 'stream';
        if (!array_key_exists($key, self::$generators)) {
            self::$generators[$key] = new StreamGenerator();
        }
        return self::$generators[$key];
    }

    public static function randomString(): RandomStringGenerator
    {
        $key = 'randomString';
        if (!array_key_exists($key, self::$generators)) {
            self::$generators[$key] = new RandomStringGenerator();
        }
        return self::$generators[$key];
    }

    public static function contentType(): ContentTypeGenerator
    {
        $key = 'contentType';
        if (!array_key_exists($key, self::$generators)) {
            self::$generators[$key] = new ContentTypeGenerator();
        }
        return self::$generators[$key];
    }

    public static function filename(): FilenameGenerator
    {
        $key = 'filename';
        if (!array_key_exists($key, self::$generators)) {
            self::$generators[$key] = new FilenameGenerator();
        }
        return self::$generators[$key];
    }

    public static function contentId(): ContentIdGenerator
    {
        $key = 'contentId';
        if (!array_key_exists($key, self::$generators)) {
            self::$generators[$key] = new ContentIdGenerator();
        }
        return self::$generators[$key];
    }

    public static function bodyPart(): BodyPartGenerator
    {
        $key = 'bodyPart';
        if (!array_key_exists($key, self::$generators)) {
            self::$generators[$key] = new BodyPartGenerator();
        }
        return self::$generators[$key];
    }

    public static function attachment(): AttachmentGenerator
    {
        $key = 'attachment';
        if (!array_key_exists($key, self::$generators)) {
            self::$generators[$key] = new AttachmentGenerator();
        }
        return self::$generators[$key];
    }

    public static function content(): ContentGenerator
    {
        $key = 'content';
        if (!array_key_exists($key, self::$generators)) {
            self::$generators[$key] = new ContentGenerator();
        }
        return self::$generators[$key];
    }
}
