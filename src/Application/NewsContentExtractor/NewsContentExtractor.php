<?php

declare(strict_types=1);

namespace App\Application\NewsContentExtractor;

class NewsContentExtractor
{
    public function extract(string $newsContent): NewsContentExtractorResult
    {
        return new NewsContentExtractorResult('news title');
    }
}
