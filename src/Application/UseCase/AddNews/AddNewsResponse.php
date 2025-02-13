<?php

declare(strict_types=1);

namespace App\Application\UseCase\AddNews;

use Ramsey\Uuid\UuidInterface;

readonly class AddNewsResponse
{
    public function __construct(
        public UuidInterface $id,
    ) {
    }
}
