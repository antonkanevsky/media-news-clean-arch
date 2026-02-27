<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function save(News $news): void;

    /**
     * @return array<News>
     */
    public function findAll(): array;

    /**
     * @param array<string> $ids
     *
     * @return array<News>
     */
    public function findByIds(array $ids): array;
}
