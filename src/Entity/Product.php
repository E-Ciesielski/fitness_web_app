<?php

namespace App\Entity;

use App\Enum\Units;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "products")]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $calories = null;

    #[ORM\Column(enumType: Units::class)]
    private ?Units $unit = null;

    #[ORM\Column]
    private ?int $unitAmount = null;

    /**
     * @var Collection<int, MealProduct>
     */
    #[ORM\OneToMany(targetEntity: MealProduct::class, mappedBy: 'product')]
    private Collection $mealProducts;

    public function __construct()
    {
        $this->mealProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function setCalories(int $calories): static
    {
        $this->calories = $calories;

        return $this;
    }

    public function getUnit(): ?Units
    {
        return $this->unit;
    }

    public function setUnit(Units $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getUnitAmount(): ?int
    {
        return $this->unitAmount;
    }

    public function setUnitAmount(int $unitAmount): static
    {
        $this->unitAmount = $unitAmount;

        return $this;
    }

    /**
     * @return Collection<int, MealProduct>
     */
    public function getMealProducts(): Collection
    {
        return $this->mealProducts;
    }
}
