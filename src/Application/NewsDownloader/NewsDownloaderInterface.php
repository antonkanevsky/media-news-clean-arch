<?php

declare(strict_types=1);

namespace App\Application\NewsDownloader;

use App\Application\NewsDownloader\Exception\DownloaderFailureException;

interface NewsDownloaderInterface
{
    /**
     * @throws DownloaderFailureException
     */
    public function downloadNews(string $url): NewsDownloaderResult;
}