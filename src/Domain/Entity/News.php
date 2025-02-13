<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Url;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class News
{
    private UuidInterface $id;

    private string $url;

    private string $title;

    private \DateTimeImmutable $createdAt;

    public function __construct(Url $url, string $title)
    {
        $this->id = Uuid::uuid7();
        $this->url = $url->value;
        $this->title = $title;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
