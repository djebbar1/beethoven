<?php

namespace App\Controller;

use App\Entity\Music;

use App\Entity\Categories;
use App\Repository\MusicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavorisController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/favoris', name: 'app_favoris')]
    public function favoris(MusicRepository $music, ManagerRegistry $doctrine)
    {
        $user = $this->getUser();
        $userId = $user->getId();
       
        $queryBuilder = $doctrine->getManager()->createQueryBuilder()
        ->select('m')
        ->from(Music::class, 'm')
        ->join('m.favorite', 'f')
        ->where('f.id = :userId')
        ->setParameter('userId', $userId);
            //dd($queryBuilder);
        $favorites = $queryBuilder->getQuery()->getResult();

        // $favorites = $doctrine->getRepository(Music::class)->findBy(['favoris'=>$user]);
        $categorie = $this->entityManager->getRepository(Categories::class)->findAll();
        return $this->render('favoris/index.html.twig', [
            'favoris' => $favorites,
            'categorie' => $categorie
        ]);
       
    }
}
