<?php

declare(strict_types=1);

namespace App\Application\UseCase\AddNews;

use App\Domain\ValueObject\Url;
use Symfony\Component\Validator\Constraints as Assert;

readonly class AddNewsRequest
{
    public function __construct(
        #[Assert\Valid]
        public Url $url,
    ) {
    }
}
