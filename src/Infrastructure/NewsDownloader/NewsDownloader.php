<?php

declare(strict_types=1);

namespace App\Infrastructure\NewsDownloader;

use App\Application\NewsDownloader\Exception\DownloaderFailureException;
use App\Application\NewsDownloader\NewsDownloaderInterface;
use App\Application\NewsDownloader\NewsDownloaderResult;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class NewsDownloader implements NewsDownloaderInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private LoggerInterface $logger,
    ) {
    }
    public function downloadNews(string $url): NewsDownloaderResult
    {
        return new NewsDownloaderResult($this->getContent($url));
    }

    private function getContent(string $url): string
    {
        try {
            $response = $this->httpClient->request('GET', $url);

            return $response->getContent();
        } catch (TransportExceptionInterface | ServerExceptionInterface | ClientExceptionInterface $e) {
            $errorMessage = 'News downloader error.';
            $this->logger->error($errorMessage, [
                'exception' => $e,
                'message' => $e->getMessage(),
            ]);

            throw new DownloaderFailureException($errorMessage, $e->getCode(), $e);
        }
    }
}
