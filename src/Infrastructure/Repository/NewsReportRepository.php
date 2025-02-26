<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\NewsReport;
use App\Domain\Repository\NewsReportRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewsReport>
 */
class NewsReportRepository extends ServiceEntityRepository implements NewsReportRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsReport::class);
    }

    public function save(NewsReport $newsReport): void
    {
        $this->getEntityManager()->persist($newsReport);
        $this->getEntityManager()->flush();
    }
}
