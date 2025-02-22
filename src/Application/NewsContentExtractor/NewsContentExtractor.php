<?php

declare(strict_types=1);

namespace App\Application\NewsContentExtractor;

class NewsContentExtractor
{
    public function extract(string $newsContent): NewsContentExtractorResult
    {
        $newsTitle = 'unrecognized title';
        if (preg_match('#<title>(.+)<\/title>#', $newsContent, $matches)) {
            $newsTitle = $matches[1];
        }

        return new NewsContentExtractorResult($newsTitle);
    }
}
