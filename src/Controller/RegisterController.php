<?php

namespace App\Controller;

use App\Entity\User;

use App\Entity\Categories;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response

    
    {
        $categorie = $this->entityManager->getRepository(Categories::class)->findAll();
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            
            $password = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'categorie' => $categorie
        ]);
    }
}
