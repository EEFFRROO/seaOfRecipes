<?php


namespace App\Service;


use App\Entity\IngredientRecipeRelation;
use App\Entity\Recipe;
use App\Entity\User;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;

class RecipeService
{
    private RecipeRepository $recipeRepository;
    private IngredientRepository $ingredientRepository;

    public function __construct(RecipeRepository $recipeRepository, IngredientRepository $ingredientRepository)
    {
        $this->recipeRepository = $recipeRepository;
        $this->ingredientRepository = $ingredientRepository;
    }

    public function getRecipes(string $searchString = '', int $limit = 10): array
    {
        if (!$searchString) {
            return $this->recipeRepository->findBy([], ['rating' => 'DESC']);
        }
        return $this->recipeRepository->findByName($searchString, $limit);
    }

    public function createRecipe(string $name, string $recipeText, array $ingredients, User $user): Recipe
    {
        $recipe = new Recipe();
        $recipe->setName($name);
        $recipe->setText($recipeText);
        $recipe->setCook($user);
        foreach ($ingredients as $ingredient) {
            $ingredientRecipe = new IngredientRecipeRelation();
            $ingredientRecipe->setIngredient($this->ingredientRepository->find($ingredient['id']));
            $ingredientRecipe->setCount($ingredient['count'] ?: 1);
            $recipe->addIngredientRecipeRelation($ingredientRecipe);
        }
        $this->recipeRepository->save($recipe, true);
        return $recipe;
    }

    public function getRecipeById(int $id): ?Recipe
    {
        return $this->recipeRepository->find($id);
    }
}