<?php

declare(strict_types=1);

namespace App\Application\UseCase\AddNews;

use Symfony\Component\Validator\Constraints as Assert;

readonly class AddNewsRequest
{
    public function __construct(
        #[Assert\Url]
        public string $url,
    ) {
    }
}
