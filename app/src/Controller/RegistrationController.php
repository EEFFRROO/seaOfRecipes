<?php


namespace App\Controller;


use App\Entity\User;
use App\Exception\NotEnoughCredentialsException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @throws NotEnoughCredentialsException
     */
    #[Route('/register', name: 'registration', methods: ['POST'])]
    public function register(Request $request)
    {
        if (!$request->get('email') || !$request->get('name') || !$request->get('password')) {
            throw new NotEnoughCredentialsException();
        }

        $user = new User();
        $user->setEmail($request->get('email'));
        $user->setName($request->get('name'));

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $request->get('password')
        );
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}