<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $volume = null;

    #[ORM\Column(nullable: true)]
    private ?int $weight = null;

    #[ORM\OneToMany(mappedBy: 'ingredient', targetEntity: IngredientRecipeRelation::class)]
    private Collection $ingredientRecipeRelations;

    public function __construct()
    {
        $this->ingredientRecipeRelations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(?int $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return Collection<int, IngredientRecipeRelation>
     */
    public function getIngredientRecipeRelations(): Collection
    {
        return $this->ingredientRecipeRelations;
    }

    public function addIngredientRecipeRelation(IngredientRecipeRelation $ingredientRecipeRelation): self
    {
        if (!$this->ingredientRecipeRelations->contains($ingredientRecipeRelation)) {
            $this->ingredientRecipeRelations->add($ingredientRecipeRelation);
            $ingredientRecipeRelation->setIngredient($this);
        }

        return $this;
    }

    public function removeIngredientRecipeRelation(IngredientRecipeRelation $ingredientRecipeRelation): self
    {
        if ($this->ingredientRecipeRelations->removeElement($ingredientRecipeRelation)) {
            // set the owning side to null (unless already changed)
            if ($ingredientRecipeRelation->getIngredient() === $this) {
                $ingredientRecipeRelation->setIngredient(null);
            }
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'volume' => $this->volume,
            'weight' => $this->weight,
        ];
    }
}
