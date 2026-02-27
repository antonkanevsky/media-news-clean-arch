<?php

declare(strict_types=1);

namespace App\Application\NewsReport;

use App\Domain\Entity\News;
use App\Domain\Entity\NewsReport;
use App\Domain\Repository\NewsReportRepositoryInterface;
use Twig\Environment;

readonly class NewsReportGenerator
{
    public function __construct(
        private Environment $twig,
        private NewsReportStorageInterface $newsReportStorage,
        private NewsReportRepositoryInterface $newsReportRepository,
    ) {
    }

    /**
     * @param array<News> $news
     */
    public function generate(array $news): NewsReport
    {
        $reportContent = $this->twig->render('news_report/news_report.html.twig', ['newsList' => $news]);
        $path = $this->newsReportStorage->save($reportContent);

        $newsReport = new NewsReport($path);
        $this->newsReportRepository->save($newsReport);

        return $newsReport;
    }
}
