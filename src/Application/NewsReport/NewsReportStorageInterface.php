<?php

declare(strict_types=1);

namespace App\Application\NewsReport;

interface NewsReportStorageInterface
{
    public function save(string $content): string;
}
