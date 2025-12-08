<?php

namespace App\Entity;

use App\Repository\DailyLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DailyLogRepository::class)]
class DailyLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column]
    private ?int $maxCalories = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMaxCalories(): ?int
    {
        return $this->maxCalories;
    }

    public function setMaxCalories(int $maxCalories): static
    {
        $this->maxCalories = $maxCalories;

        return $this;
    }
}
