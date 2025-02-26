<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateNewsReport;

use App\Application\Exception\UseCase\InvalidInputRequestException;
use App\Application\NewsReport\NewsReportGenerator;
use App\Application\UseCase\CreateNewsReport\Exception\CreateNewsReportUseCaseException;
use App\Application\Validation\ValidationErrorsParser;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateNewsReportUseCase
{
    public function __construct(
        private ValidatorInterface $validator,
        private NewsRepositoryInterface $newsRepository,
        private NewsReportGenerator $newsReportGenerator,
    ) {
    }

    public function __invoke(CreateNewsReportRequest $request): CreateNewsReportResponse
    {
        $errors = $this->validator->validate($request);
        if ($errors->count() > 0) {
            throw new InvalidInputRequestException(ValidationErrorsParser::getMessage($errors));
        }
        $newsList = $this->newsRepository->findByIds($request->ids);
        $this->assertAllNewsExists($newsList, $request->ids);

        try {
            $newsReport = $this->newsReportGenerator->generate($newsList);
        } catch (\Exception $e) {
            throw new CreateNewsReportUseCaseException('Error creating news report', $e->getCode(), $e);
        }

        return new CreateNewsReportResponse($newsReport->getId());
    }

    private function assertAllNewsExists(array $newsList, array $ids): void
    {
        $notFoundNewsIds = array_diff($ids, array_map(static fn (News $news): string => $news->getId()->toString(), $newsList));
        if ($notFoundNewsIds !== []) {
            throw new CreateNewsReportUseCaseException('News not found: ' . implode(', ', $notFoundNewsIds));
        }
    }
}
