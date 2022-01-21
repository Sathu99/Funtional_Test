<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserLoginType;
use App\Form\UserSignupType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user.")
 */
class UserController extends AbstractController
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var \App\Repository\UserRepository
     */
    private $userRepository;
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $propertyAccessor;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Repository\UserRepository $userRepository
     */
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();

    }

    /**
     * @Route("/login",name="login")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request): Response
    {
        $newUser = new User();
        $form_login = $this->createForm(UserLoginType::class);
        $form_signup = $this->createForm(UserSignupType::class, $newUser);

        $form_login->handleRequest($request);
        $form_signup->handleRequest($request);

        if ($form_login->isSubmitted() && $form_login->isValid()) {
            $user = $this->userRepository->findOneBy(['email' => $this->propertyAccessor->getValue($form_login->getData(), 'email')]);
            if ($user) {
                if ($this->propertyAccessor->getValue($user, 'password') === $this->propertyAccessor->getValue($form_login->getData(), 'password')) {
                    $this->addFlash('success', 'You are Successfully LoggedIn.');
                } else {
                    $this->addFlash('error', 'Your Password is Invalid.');
                }
            } else {
                $this->addFlash('error', 'You are not Sign Up Yet, First You want Sign up.');
            }
        } elseif ($form_signup->isSubmitted() && $form_signup->isValid()) {

            $this->entityManager->persist($newUser);
            $this->entityManager->flush();

            $this->addFlash('success', 'You are Successfully SignedUp.');
        } else if (!($form_signup->isSubmitted() || $form_login->isSubmitted())) {
            $this->addFlash('info', 'Welcome to LoginPage.');
        } else {
            $this->addFlash('error', 'Your Details are Not Valid.');
        }
        return $this->render('user/index.html.twig', [
            'form_login' => $form_login->createView(),
            'form_signup' => $form_signup->createView()
        ]);
    }
}
