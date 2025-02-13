<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class Url implements \Stringable
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Url]
        public string $value,
    ){
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
