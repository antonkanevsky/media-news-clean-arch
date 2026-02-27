<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class NewsReport
{
    private UuidInterface $id;

    private string $filePath;

    private \DateTimeImmutable $createdAt;

    public function __construct(string $filePath)
    {
        $this->id = Uuid::uuid7();
        $this->filePath = $filePath;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
