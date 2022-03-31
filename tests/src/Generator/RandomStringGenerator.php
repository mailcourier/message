<?php

declare(strict_types=1);

namespace Staff\Postboy\Message\Generator;

class RandomStringGenerator
{
    private array $parts = [
        'lower' => 'abcdefghijklmnopqrstuvwxyz',
    ];
    private int $length = 10;

    public function withUpperLetters(): self
    {
        $that = clone $this;
        $that->parts['upper'] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return $that;
    }

    public function withoutUpperLetters(): self
    {
        $that = clone $this;
        if (array_key_exists('upper', $that->parts)) {
            unset($that->parts['upper']);
        }
        return $that;
    }

    public function withSpace(): self
    {
        $that = clone $this;
        $that->parts['space'] = ' ';
        return $that;
    }

    public function withoutSpace(): self
    {
        $that = clone $this;
        if (array_key_exists('space', $that->parts)) {
            unset($that->parts['space']);
        }
        return $that;
    }

    public function withLowerLetters(): self
    {
        $that = clone $this;
        $that->parts['lower'] = 'abcdefghijklmnopqrstuvwxyz';
        return $that;
    }

    public function withoutLowerLetters(): self
    {
        $that = clone $this;
        if (array_key_exists('lower', $that->parts)) {
            unset($that->parts['lower']);
        }
        return $that;
    }

    public function withDecimals(): self
    {
        $that = clone $this;
        $that->parts['decimals'] = '0123456789';
        return $that;
    }

    public function withoutDecimals(): self
    {
        $that = clone $this;
        if (array_key_exists('decimals', $that->parts)) {
            unset($that->parts['decimals']);
        }
        return $that;
    }

    public function withSpecial(): self
    {
        $that = clone $this;
        $that->parts['special'] = '!@#$%^&*()_+';
        return $that;
    }

    public function withoutSpecial(): self
    {
        $that = clone $this;
        if (array_key_exists('special', $that->parts)) {
            unset($that->parts['special']);
        }
        return $that;
    }

    public function withLength(int $length): self
    {
        if ($length < 1) {
            $length = 1;
        }
        $that = clone $this;
        $that->length = $length;
        return $that;
    }

    public function make(): string
    {
        $result = '';
        for ($i = 0; $i < $this->length; $i++) {
            $part = $this->parts[array_rand($this->parts)];
            $characters = str_split($part);
            $result .= $characters[array_rand($characters)];
        }
        return $result;
    }
}
