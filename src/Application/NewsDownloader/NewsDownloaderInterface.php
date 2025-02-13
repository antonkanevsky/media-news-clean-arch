<?php

declare(strict_types=1);

namespace App\Application\NewsDownloader;

use App\Application\NewsDownloader\Exception\DownloaderFailureException;
use App\Domain\ValueObject\Url;

interface NewsDownloaderInterface
{
    /**
     * @throws DownloaderFailureException
     */
    public function downloadNews(Url $url): NewsDownloaderResult;
}