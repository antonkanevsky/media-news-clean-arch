<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

readonly class NewsRepository implements NewsRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(News $news): void
    {
        $this->entityManager->persist($news);
        $this->entityManager->flush();
    }
}
