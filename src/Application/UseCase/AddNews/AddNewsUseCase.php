<?php

declare(strict_types=1);

namespace App\Application\UseCase\AddNews;

use App\Application\Exception\UseCase\InvalidInputRequestException;
use App\Application\NewsContentExtractor\NewsContentExtractor;
use App\Application\NewsDownloader\Exception\DownloaderFailureException;
use App\Application\NewsDownloader\NewsDownloaderInterface;
use App\Application\UseCase\AddNews\Exception\AddNewsUseCaseException;
use App\Application\Validation\ValidationErrorsParser;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class AddNewsUseCase
{
    public function __construct(
        private NewsDownloaderInterface $newsDownloader,
        private NewsContentExtractor $newsContentExtractor,
        private ValidatorInterface $validator,
        private NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $errors = $this->validator->validate($request);
        if ($errors->count() > 0) {
            throw new InvalidInputRequestException(ValidationErrorsParser::getMessage($errors));
        }

        try {
            $newsDownloaderResult = $this->newsDownloader->downloadNews($request->url);
        } catch (DownloaderFailureException $e) {
            throw new AddNewsUseCaseException('Error downloading news.', $e->getCode(), $e);
        }

        $newsExtractorResult = $this->newsContentExtractor->extract($newsDownloaderResult->urlContent);

        $news = new News($request->url, $newsExtractorResult->title);
        $this->newsRepository->save($news);

        return new AddNewsResponse($news->getId());
    }
}
