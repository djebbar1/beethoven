<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\MusicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager; 
    }
    #[Route('/', name: 'home')]
    public function index(MusicRepository $musicRepository): Response
    {
        $categorie = $this->entityManager->getRepository(Categories::class)->findAll();
        $musiques = $musicRepository->findAll();
      
        return $this->render('home/index.html.twig', [
            'music' => $musiques,
            'categorie' => $categorie
        ]);
    }
}
