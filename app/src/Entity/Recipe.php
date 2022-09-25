<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?float $rating = null;

    #[ORM\Column(length: 4095)]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    private ?User $cook = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Review::class)]
    private Collection $reviews;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: IngredientRecipeRelation::class)]
    private Collection $ingredientRecipeRelations;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
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

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCook(): ?User
    {
        return $this->cook;
    }

    public function setCook(?User $cook): self
    {
        $this->cook = $cook;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setRecipe($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getRecipe() === $this) {
                $review->setRecipe(null);
            }
        }

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
            $ingredientRecipeRelation->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredientRecipeRelation(IngredientRecipeRelation $ingredientRecipeRelation): self
    {
        if ($this->ingredientRecipeRelations->removeElement($ingredientRecipeRelation)) {
            // set the owning side to null (unless already changed)
            if ($ingredientRecipeRelation->getRecipe() === $this) {
                $ingredientRecipeRelation->setRecipe(null);
            }
        }

        return $this;
    }
}
