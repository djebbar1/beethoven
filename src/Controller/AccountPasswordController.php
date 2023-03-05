<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;


class AccountPasswordController extends AbstractController
{
   
    private $entityManager;
    // #[param($entityManager)]
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/compte/modifier-mon-mot-de-passe', name: 'account_password')]
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        
        // $encoder = null;
        $notification = null;
        $user=$this->getUser();
        $form =$this->createForm(ChangePasswordType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $old_password = $form->get('old_password')->getData();

            if ($encoder->isPasswordValid($user, $old_password)){
                $new_password = $form->get('new_password')->getData();
                // dd($new_password);
                $password = $encoder->encodePassword($user, $new_password);
                // $password = $encoder->encoderPassword($user, $new_password);
            
                
                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = 'Votre mot de passe à bien été mise à jour';
             }else{
                 $notification = "Votre mot de passe actuel n'est pas bon";
             }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
    }


