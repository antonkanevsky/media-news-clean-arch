<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateNewsReport;

use Ramsey\Uuid\UuidInterface;

final readonly class CreateNewsReportResponse
{
    public function __construct(
        public UuidInterface $id,
    ) {
    }
}
