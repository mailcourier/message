<?php

declare(strict_types=1);

namespace Staff\Postboy\Message\Generator;

use Postboy\Contract\Message\Type\ContentId;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class ContentIdGenerator
{
    private ?string $id = null;

    public function withId(string $id): self
    {
        $that = clone $this;
        $that->id = $id;
        return $that;
    }

    public function make(): ContentId
    {
        $id = $this->id;
        if (is_null($id)) {
            $id = GeneratorFactory::randomString()
                ->withLowerLetters()
                ->withUpperLetters()
                ->withDecimals()
                ->withSpecial()
                ->withLength(20)
                ->make()
            ;
        }
        return new ContentId($id);
    }
}
