<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Exception\UseCase\InvalidInputRequestException;
use App\Application\UseCase\CreateNewsReport\CreateNewsReportRequest;
use App\Application\UseCase\CreateNewsReport\CreateNewsReportUseCase;
use App\Application\UseCase\CreateNewsReport\Exception\CreateNewsReportUseCaseException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class ReportNewsController extends AbstractController
{
    public function __construct(
        private readonly CreateNewsReportUseCase $createNewsReportUseCase,
        private readonly LoggerInterface $logger,
    ) {
    }

    #[Route('api/v1/news-report', name: 'create_news_report', methods: ['POST'], format: 'json')]
    public function __invoke(#[MapRequestPayload] CreateNewsReportRequest $request): JsonResponse
    {
        try {
            $useCaseResponse = ($this->createNewsReportUseCase)($request);
        } catch (InvalidInputRequestException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        } catch (CreateNewsReportUseCaseException $e) {
            return $this->json(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            $this->logger->error('Create news report error.', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            return $this->json(['error' => 'Something went wrong.']);
        }

        return $this->json(['id' => $useCaseResponse->id], 201);
    }
}
