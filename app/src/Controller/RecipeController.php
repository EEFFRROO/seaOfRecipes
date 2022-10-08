<?php


namespace App\Controller;


use App\Entity\Recipe;
use App\Service\RecipeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    public const CREATE_RECIPES_ROUTE = '/createRecipe';
    public const CREATE_RECIPES_ROUTE_NAME = 'createRecipe';
    public const GET_RECIPE_ROUTE = '/getRecipes';
    public const GET_RECIPE_ROUTE_NAME = 'getRecipes';
    public const CREATE_RECIPE_CONFIRM_ROUTE = '/createRecipeConfirm';
    public const CREATE_RECIPE_CONFIRM_ROUTE_NAME = 'createRecipeConfirm';
    public const RECIPE_INFO_ROUTE = '/recipeInfo';
    public const RECIPE_INFO_ROUTE_NAME = 'recipeInfo';
    private RecipeService $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    #[Route(self::CREATE_RECIPES_ROUTE, name: self::CREATE_RECIPES_ROUTE_NAME)]
    public function renderCreateRecipeForm(Request $request): Response
    {
        return $this->render('recipe/new_recipe_page.html.twig');
    }

    #[Route(self::GET_RECIPE_ROUTE, name: self::GET_RECIPE_ROUTE_NAME)]
    public function getRecipes(Request $request): Response
    {
        $searchString = $request->get('searchString') ?? '';
        $recipes = $this->recipeService->getRecipes($searchString);
        return new JsonResponse($recipes);
    }

    #[Route(self::CREATE_RECIPE_CONFIRM_ROUTE, name: self::CREATE_RECIPE_CONFIRM_ROUTE_NAME)]
    public function createRecipe(Request $request): Response
    {
        $user = $this->getUser();
        $recipeRequest = $request->get('recipe');
        if (
            !isset($recipeRequest['name'])
            || !isset($recipeRequest['text'])
            || !isset($recipeRequest['ingredients'])
        ) {
            throw new \Exception();
        }
        $recipe = $this->recipeService->createRecipe(
            $recipeRequest['name'],
            $recipeRequest['text'],
            $recipeRequest['ingredients'],
            $user
        );
        return new JsonResponse($recipe);
    }

    #[Route(self::RECIPE_INFO_ROUTE, name: self::RECIPE_INFO_ROUTE_NAME)]
    public function renderRecipePage(Request $request): Response
    {
        $recipeId = $request->get('id');
        $recipe = $this->recipeService->getRecipeById($recipeId);
        return $this->render('recipe/recipe_info_page.html.twig',
            [
                'recipe' => $recipe
            ]
        );
    }
}