<?php

declare(strict_types=1);

namespace App\Application\UseCase\NewsList;

use App\Domain\Repository\NewsRepositoryInterface;

readonly class NewsListUseCase
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function __invoke()
    {
        return $this->newsRepository->findAll();
    }
}
