<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Music;
use App\Repository\MusicRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
//use Proxies\__CG__\App\Entity\Categories;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    //private $categories;

    #[Route('/nos-categories', name: 'app_categories')]
    
    public function index(MusicRepository $music, ManagerRegistry $doctrine): Response
    //public function index(CategoriesRepository $categoriesRepository): Response
    
    //public function index(MusicRepository $musicRepository): Response
    {
        //$categorie = $this->entityManager->getRepository(Categories::class)->findAll();
        //$musiques = $musicRepository->findAll();
        //dd($musiques);

        //return $this->render('categorie/index.html.twig',[
            //'categorie' => $categorie,
            //'music' =>$musiques
            
        $categorie = $this->entityManager->getRepository(Categories::class)->findAll();
        
        $musiques = $music->findAll();
        

        return $this->render('categorie/index.html.twig', [
            'categorie' => $categorie,
            'music' => $musiques

        ]);
    }
    
}
