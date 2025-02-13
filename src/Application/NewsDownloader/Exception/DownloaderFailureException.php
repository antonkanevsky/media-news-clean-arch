<?php

declare(strict_types=1);

namespace App\Application\NewsDownloader\Exception;

use App\Domain\ValueObject\Url;

class DownloaderFailureException extends \RuntimeException
{
    public readonly Url $url;

    public function __construct(Url $url)
    {
        parent::__construct(sprintf('Empty resource\'s "%s" data.', $url));
    }
}
