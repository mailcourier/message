<?php

declare(strict_types=1);

namespace Tests\Postboy\Message\Body\Collection;

use InvalidArgumentException;
use Postboy\Message\Body\Body;
use Postboy\Message\Body\Collection\ArrayBodyCollection;
use Postboy\Contract\Message\Body\Collection\BodyCollectionInterface;

class ArrayBodyCollectionTest extends BodyCollectionTestCase
{
    protected function createBodyCollection(Body ...$bodies): BodyCollectionInterface
    {
        if (count($bodies) < 1) {
            throw new InvalidArgumentException('minimum 1 body');
        }
        $first = array_shift($bodies);
        $collection = new ArrayBodyCollection($first);
        foreach ($bodies as $body) {
            $collection->add($body);
        }
        return $collection;
    }
}
