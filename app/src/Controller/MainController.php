<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    public const MAIN_ROUTE = '/';
    public const MAIN_ROUTE_NAME = 'main';

    #[Route(self::MAIN_ROUTE, name: self::MAIN_ROUTE_NAME)]
    public function main(): Response
    {
        return $this->render('main.html.twig');
    }
}