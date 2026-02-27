<?php

declare(strict_types=1);

namespace App\Infrastructure\NewsReport;

use App\Application\NewsReport\NewsReportStorageInterface;
use League\Flysystem\FilesystemOperator;

readonly class NewsReportStorage implements NewsReportStorageInterface
{
    public function __construct(
        private FilesystemOperator $newsReportStorage,
    ) {
    }

    public function save(string $content): string
    {
        $filePath = $this->generateFilePath();
        $this->newsReportStorage->write($filePath, $content);

        return $filePath;
    }

    private function generateFilePath(): string
    {
        return sprintf('%s.html', uniqid('news-report_'));
    }
}
