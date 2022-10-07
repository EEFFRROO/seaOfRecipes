<?php


namespace App\Controller;


use App\Exception\NotEnoughCredentialsException;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    public const LOGIN_ROUTE = '/login';
    public const LOGIN_ROUTE_NAME = 'login';
    public const LOGIN_CONFIRM_ROUTE = '/loginConfirm';
    public const LOGIN_CONFIRM_ROUTE_NAME = 'loginConfirm';
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route(self::LOGIN_ROUTE, name: self::LOGIN_ROUTE_NAME)]
    public function login(): Response
    {
        return $this->render('user/login.html.twig');
    }

    /**
     * @throws \Exception
     */
    #[Route(self::LOGIN_CONFIRM_ROUTE, name: self::LOGIN_CONFIRM_ROUTE_NAME)]
    public function loginConfirm(Request $request): Response
    {
        if (!($email = $request->get('email')) || !($password = $request->get('password'))) {
            throw new NotEnoughCredentialsException();
        }
        $user = $this->userService->login($email, $password);
        return new JsonResponse(['token' => $user->getToken()]);
    }
}