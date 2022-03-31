<?php

declare(strict_types=1);

namespace Staff\Postboy\Message\Generator;

use Postboy\Contract\Message\Type\Filename;
use Staff\Postboy\Message\Generator\Factory\GeneratorFactory;

class FilenameGenerator
{
    private ?string $name = null;

    public function withName(string $name): self
    {
        $that = clone $this;
        $that->name = $name;
        return $that;
    }

    public function make(): Filename
    {
        $name = $this->name;
        if (is_null($name)) {
            $name = GeneratorFactory::randomString()
                ->withLowerLetters()
                ->withUpperLetters()
                ->withDecimals()
                ->withoutSpecial()
                ->withLength(10)
                ->make()
            ;
            $name .= '.' . GeneratorFactory::randomString()
                ->withLowerLetters()
                ->withoutUpperLetters()
                ->withoutDecimals()
                ->withoutSpecial()
                ->withLength(3)
                ->make()
            ;
        }
        return new Filename($name);
    }
}
