<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Exception\UseCase\InvalidInputRequestException;
use App\Application\UseCase\AddNews\AddNewsRequest;
use App\Application\UseCase\AddNews\AddNewsUseCase;
use App\Application\UseCase\AddNews\Exception\AddNewsUseCaseException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class AddNewsController extends AbstractController
{
    public function __construct(
        private readonly AddNewsUseCase $addNewsUseCase,
        private readonly LoggerInterface $logger,
    ) {
    }

    #[Route('api/v1/news', name: 'create_news', methods: ['POST'], format: 'json')]
    public function __invoke(#[MapRequestPayload] AddNewsRequest $request): JsonResponse
    {
        try {
            $useCaseResponse = ($this->addNewsUseCase)($request);
        } catch (InvalidInputRequestException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        } catch (AddNewsUseCaseException $e) {
            return $this->json(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            $this->logger->error('Add news error.', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            return $this->json(['error' => 'Something went wrong.']);
        }

        return $this->json(['id' => $useCaseResponse->id], 201);
    }
}
