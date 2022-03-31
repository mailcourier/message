<?php

declare(strict_types=1);

namespace Tests\Postboy\Message\Body\Collection;

use Postboy\Message\Body\Body;
use Postboy\Message\Body\BodyPart;
use Postboy\Contract\Message\Body\Collection\BodyCollectionInterface;
use Postboy\Contract\Message\Exception\CanNotRemoveLastElement;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

abstract class BodyCollectionTestCase extends TestCase
{
    final public function testAdd()
    {
        $body = $this->createBodyPart('part#1');
        $collection = $this->createBodyCollection($body);
        Assert::assertCount(1, $collection);
        $collection->add($body);
        Assert::assertCount(1, $collection);
        for ($num = 2; $num <= 100; $num++) {
            $collection->add($this->createBodyPart(sprintf('part#%d', $num)));
            Assert::assertCount($num, $collection);
        }
    }

    final public function testRemove()
    {
        $bodies = [];
        for ($num = 1; $num <= 100; $num++) {
            $body = $this->createBodyPart(sprintf('part#%d', $num));
            $bodies[] = $body;
        }
        $collection = $this->createBodyCollection(...$bodies);

        $first = array_shift($bodies);
        $counter = 99;
        foreach ($bodies as $body) {
            $collection->remove($body);
            Assert::assertCount($counter, $collection);
            $counter--;
        }

        Assert::assertCount(1, $collection);
        $this->expectException(CanNotRemoveLastElement::class);
        $collection->remove($first);
    }

    final public function testForeach()
    {
        $bodies = [];
        for ($num = 1; $num <= 100; $num++) {
            $key = sprintf('part#%\'.03d', $num);
            $body = $this->createBodyPart($key);
            $bodies[$key] = $body;
        }
        $collection = $this->createBodyCollection(...array_values($bodies));

        do {
            $idx = array_rand($bodies);
            $body = $bodies[$idx];
            $collection->remove($body);
            unset($bodies[$idx]);
        } while (count($collection) > 90);

        Assert::assertCount(90, $collection);
        foreach ($collection as $body) {
            Assert::assertInstanceOf(BodyPart::class, $body);
            /** @var BodyPart $body */
            $key = $body->getStream()->read(8);
            Assert::assertArrayHasKey($key, $bodies);
            Assert::assertSame($bodies[$key], $body);
            unset($bodies[$key]);
        }
        Assert::assertCount(0, $bodies);
    }

    private function createBodyPart(string $content): BodyPart
    {
        $stream = GeneratorFactory::stream()->withContents($content)->make();
        $contentType = GeneratorFactory::contentType()->make();
        return GeneratorFactory::bodyPart()->withStream($stream)->withContentType($contentType)->make();
    }

    abstract protected function createBodyCollection(Body ...$bodies): BodyCollectionInterface;
}
