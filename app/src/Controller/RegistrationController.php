<?php


namespace App\Controller;


use App\Exception\NotEnoughCredentialsException;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private UserService $userService;

    public const REGISTER_ROUTE = '/register';
    public const REGISTER_ROUTE_NAME = 'registration';
    public const REGISTRATION_CONFIRM_ROUTE = '/registrationConfirm';
    public const REGISTRATION_CONFIRM_ROUTE_NAME = 'registrationConfirm';

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route(self::REGISTER_ROUTE, name: self::REGISTER_ROUTE_NAME)]
    public function renderRegistrationForm(Request $request): Response
    {
        return $this->render('user/registration.html.twig');
    }

    /**
     * @throws NotEnoughCredentialsException
     * @throws \App\Exception\UserAlreadyExistException
     */
    #[Route(self::REGISTRATION_CONFIRM_ROUTE, name: self::REGISTRATION_CONFIRM_ROUTE_NAME, methods: ['POST'])]
    public function registrationConfirm(Request $request): Response
    {
        if (
            !($email = $request->get('email'))
            || !($name = $request->get('name'))
            || !($password = $request->get('password'))
        ) {
            throw new NotEnoughCredentialsException();
        }

        $this->userService->register($email, $name, $password);
        return new JsonResponse(['redirectPage' => LoginController::LOGIN_ROUTE]);
    }
}