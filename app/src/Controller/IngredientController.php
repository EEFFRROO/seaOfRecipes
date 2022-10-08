<?php


namespace App\Controller;


use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    public const GET_INGREDIENTS_ROUTE = '/getIngredients';
    public const GET_INGREDIENTS_ROUTE_NAME = 'getIngredients';
    private IngredientRepository $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    #[Route(self::GET_INGREDIENTS_ROUTE, name: self::GET_INGREDIENTS_ROUTE_NAME)]
    public function getIngredients(Request $request): Response
    {
        return new JsonResponse($this->ingredientRepository->findAll());
    }
}