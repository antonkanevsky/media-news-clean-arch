<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\NewsList\NewsListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class NewsListController extends AbstractController
{
    public function __construct(
        private readonly NewsListUseCase $listUseCase,
    ) {
    }

    #[Route('api/v1/news', name: 'news_list', methods: ['GET'], format: 'json')]
    public function __invoke(): JsonResponse
    {
        $news = ($this->listUseCase)();

        return $this->json($news);
    }
}
