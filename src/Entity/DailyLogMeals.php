<?php

namespace App\Entity;

use App\Repository\DailyLogMealsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DailyLogMealsRepository::class)]
class DailyLogMeals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?DailyLog $dailyLog = null;

    #[ORM\ManyToOne]
    private ?Meal $meal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDailyLog(): ?DailyLog
    {
        return $this->dailyLog;
    }

    public function setDailyLog(?DailyLog $dailyLog): static
    {
        $this->dailyLog = $dailyLog;

        return $this;
    }

    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    public function setMeal(?Meal $meal): static
    {
        $this->meal = $meal;

        return $this;
    }
}
