<?php


namespace App\Security;


use App\Entity\User;
use App\Exception\UserBadTokenException;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class TokenAuthenticator extends AbstractAuthenticator
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request): ?bool
    {
        return true;
    }

    /**
     * @inheritDoc
     * @throws UserBadTokenException
     */
    public function authenticate(Request $request): Passport
    {
        $token = $request->cookies->get('seaOfRecipesToken');
        if (!$token || !$user = $this->userRepository->findOneBy(['token' => $token])) {
            throw new UserBadTokenException();
        }
        return new Passport(new UserBadge($user->getUserIdentifier()), new CustomCredentials(
            function ($credentials, User $user) {
                return $user->getToken() === $credentials;
            },
            $token
        ));
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    /**
     * @inheritDoc
     * @throws UserBadTokenException
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        throw new UserBadTokenException();
    }
}