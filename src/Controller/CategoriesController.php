<?php

namespace App\Controller;

use App\Entity\Music;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/nos-categories', name: 'app_categories')]
    public function index(): Response
    {
        $musiques = $this->entityManager->getRepository(Categories::class)->findAll();
        //dd($musiques);

        return $this->render('categorie/index.html.twig',[
            'musiques' => $musiques
        ]);
    }
}
