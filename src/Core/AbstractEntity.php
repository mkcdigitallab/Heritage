<?php

declare(strict_types=1);

namespace App\Core;

abstract class AbstractEntity
{
    protected ?int $id;
    protected \DateTimeImmutable $dateCreation;

    public function __construct(?int $id = null, ?\DateTimeImmutable $dateCreation = null)
    {
        $this->id = $id;
        $this->dateCreation = $dateCreation ?? new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): \DateTimeImmutable
    {
        return $this->dateCreation;
    }
}
