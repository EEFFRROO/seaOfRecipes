<?php


namespace App\Listener;


use App\Controller\LoginController;
use App\Exception\NotEnoughCredentialsException;
use App\Exception\UserAlreadyExistException;
use App\Exception\UserBadPasswordException;
use App\Exception\UserBadTokenException;
use App\Exception\UserNotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $message = sprintf(
            'Возникла ошибка: "<span style="color: red; font-weight: bold;">%s</span>" с кодом: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        $response = new Response();

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } elseif ($exception instanceof NotEnoughCredentialsException) {
            $message = 'Указаны не все данные';
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        } elseif ($exception instanceof UserAlreadyExistException) {
            $message = 'Пользователь с такой почтой уже существует';
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        } elseif ($exception instanceof UserNotFoundException) {
            $message = 'Пользователь не зарегистрирован';
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        } elseif ($exception instanceof UserBadPasswordException) {
            $message = 'Неверно указаны данные';
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        } elseif ($exception instanceof UserBadTokenException) {
            $message = 'Неверный токен.';
            $response = new RedirectResponse(LoginController::LOGIN_ROUTE);
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $response->setContent($message);

        $event->setResponse($response);
    }
}