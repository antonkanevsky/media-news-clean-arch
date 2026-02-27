<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\NewsReport;

interface NewsReportRepositoryInterface
{
    public function save(NewsReport $newsReport): void;
}
