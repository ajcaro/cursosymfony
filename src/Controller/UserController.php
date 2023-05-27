<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/register', name: 'user_register')]
    public function register(Request $request, EntityManagerInterface $em,UserPasswordHasherInterface $passwordHasher ): Response
    {

        $user = new User();
        $registrationForm = $this->createForm(UserType::class, $user);
        $registrationForm->handleRequest($request);


        if ($registrationForm->isSubmitted() && $registrationForm->isValid()){
            $user->setRoles(['ROLE_USER']);
            $passwordEncrypted = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($passwordEncrypted);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_register');
        }

        return $this->render('user/index.html.twig', [
            'form' => $registrationForm,
        ]);
    }
}
