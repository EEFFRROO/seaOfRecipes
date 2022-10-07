<?php


namespace App\Service;


use App\Entity\User;
use App\Exception\UserAlreadyExistException;
use App\Exception\UserBadPasswordException;
use App\Exception\UserNotFoundException;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserPasswordHasherInterface $passwordHasher;
    private UserRepository $userRepository;
    private JWTTokenManagerInterface $JWTManager;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository,
        JWTTokenManagerInterface $JWTManager
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
        $this->JWTManager = $JWTManager;
    }

    /**
     * @throws UserAlreadyExistException
     */
    public function register(string $email, string $name, string $password): User
    {
        if ($this->userRepository->findOneBy(['email' => $email])) {
            throw new UserAlreadyExistException();
        }
        $user = new User();
        $user->setEmail($email);
        $user->setName($name);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user, true);
        return $user;
    }

    /**
     * @throws UserNotFoundException
     * @throws UserBadPasswordException
     */
    public function login(string $email, string $password): User
    {
        if (!($user = $this->userRepository->findOneBy(['email' => $email]))) {
            throw new UserNotFoundException();
        }
        if (!$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new UserBadPasswordException();
        }
        $token = $this->JWTManager->create($user);
        $user->setToken($token);

        $this->userRepository->flush();
        return $user;
    }
}