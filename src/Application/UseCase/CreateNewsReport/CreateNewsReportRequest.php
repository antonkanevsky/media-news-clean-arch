<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateNewsReport;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateNewsReportRequest
{
    public function __construct(
        /**
         * @var array<string>
         */
        #[Assert\All([new Assert\Uuid])]
        public array $ids,
    ) {
    }
}
