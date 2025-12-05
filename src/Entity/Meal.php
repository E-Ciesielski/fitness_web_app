<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "meals")]
#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, MealProduct>
     */
    #[ORM\OneToMany(targetEntity: MealProduct::class, mappedBy: 'meal')]
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

    /**
     * @return Collection<int, MealProduct>
     */
    public function getMealProducts(): Collection
    {
        return $this->mealProducts;
    }

    public function addMealProduct(MealProduct $mealProduct): static
    {
        $mealProduct->setMeal($this);
        if (!$this->mealProducts->contains($mealProduct)) {
            $this->mealProducts->add($mealProduct);
        }

        return $this;
    }

    public function removeMealProduct(MealProduct $mealProduct): static
    {
        if ($this->mealProducts->removeElement($mealProduct)) {
            // set the owning side to null (unless already changed)
            if ($mealProduct->getMeal() === $this) {
                $mealProduct->setMeal(null);
            }
        }

        return $this;
    }
}
