<?php

declare(strict_types=1);

namespace Tests\Postboy\Message\Body;

use Postboy\Message\Body\BodyPart;
use Postboy\Contract\Message\Body\Stream\StreamInterface;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

abstract class BodyPartTestCase extends TestCase
{
    final protected function assertBodyPart(BodyPart $bodyPart, StreamInterface $stream, string $contentType)
    {
        Assert::assertSame($stream, $bodyPart->getStream());
        Assert::assertSame($contentType, $bodyPart->getContentType());
    }

    final protected function createStream(): StreamInterface
    {
        return GeneratorFactory::stream()->make();
    }

    final protected function createContentType(): string
    {
        return GeneratorFactory::contentType()->make();
    }
}
