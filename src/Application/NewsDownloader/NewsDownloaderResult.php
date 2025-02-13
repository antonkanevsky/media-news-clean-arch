<?php

declare(strict_types=1);

namespace App\Application\NewsDownloader;

final readonly class NewsDownloaderResult
{
    public function __construct(
        public string $urlContent,
    ) {
    }
}
