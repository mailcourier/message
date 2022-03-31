<?php

declare(strict_types=1);

namespace Tests\Postboy\Message\Body;

use Postboy\Message\Body\Collection\ArrayBodyCollection;
use Postboy\Contract\Message\Body\Collection\BodyCollectionInterface;
use Postboy\Message\Body\MultipartBody;
use Postboy\Contract\Message\Type\MultipartType;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class MultipartBodyTest extends TestCase
{
    public function testOk()
    {
        $bodies = $this->createBodyCollection(rand(1, 10));
        $boundary = GeneratorFactory::randomString()
            ->withUpperLetters()
            ->withLowerLetters()
            ->withDecimals()
            ->withoutSpecial()
            ->withLength(32)
            ->make()
        ;
        $contentType = MultipartType::mixed();
        $multipart = new MultipartBody($bodies, $contentType, $boundary);
        Assert::assertSame($bodies, $multipart->getParts());
        Assert::assertSame($boundary, $multipart->getBoundary());
        Assert::assertSame((string)$contentType, $multipart->getContentType());
    }

    private function createBodyCollection(int $count): BodyCollectionInterface
    {
        if ($count < 1) {
            $count = 1;
        }
        $first = GeneratorFactory::bodyPart()->make();
        $collection = new ArrayBodyCollection($first);
        if ($count === 1) {
            return $collection;
        }
        for ($i = 1; $i < $count; $i++) {
            $collection->add(GeneratorFactory::bodyPart()->make());
        }
        return $collection;
    }
}
