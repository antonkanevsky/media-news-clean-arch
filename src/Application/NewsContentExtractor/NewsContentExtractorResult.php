<?php

declare(strict_types=1);

namespace App\Application\NewsContentExtractor;

final readonly class NewsContentExtractorResult
{
    public function __construct(
        public string $title,
    ) {
    }
}
