<?php

declare(strict_types=1);

namespace App\Infrastructure\NewsDownloader;

use App\Application\NewsDownloader\Exception\DownloaderFailureException;
use App\Application\NewsDownloader\NewsDownloaderInterface;
use App\Application\NewsDownloader\NewsDownloaderResult;
use App\Domain\ValueObject\Url;

class NewsDownloader implements NewsDownloaderInterface
{
    public function downloadNews(Url $url): NewsDownloaderResult
    {
        $urlContent = file_get_contents($url->value);
        if ($urlContent === false) {
            throw new DownloaderFailureException($url);
        }

        return new NewsDownloaderResult($urlContent);
    }
}