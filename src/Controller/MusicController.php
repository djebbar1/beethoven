<?php

namespace App\Controller;

use App\Entity\Music;
use App\Entity\Categories;
use App\Repository\MusicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
//use Proxies\__CG__\App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MusicController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/music', name: 'app_music')]
    public function index(): Response
    {
        $categorie = $this->entityManager->getRepository(Categories::class)->findAll();
        $musiques = $this->entityManager->getRepository(Music::class)->findAll();
        //dd($musiques);
        return $this->render('music/index.html.twig', [
            'music' => $musiques,
            'categorie' => $categorie,
        ]);
    }
    #[Route('/', name: 'app_base')]
    public function categorie(): Response
    {
        $categorie = $this->entityManager->getRepository(Categories::class)->findAll();
        //dd($musiques);
        return $this->render('base.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    //ajouter les music au favories

    #[Route('/favoris/ajout/{id}', name: 'ajout_favoris')]     
    public function ajoutFavorite(Music $music, ManagerRegistry $doctrine)     
    {         
        $music->addFavorite($this->getUser());          
        $em = $doctrine->getManager();         
        $em->persist($music);         
        $em->flush();         
         return $this->redirectToRoute('app_music');     
        }


//sup music au fav

    #[Route('/favoris/delete/{id}', name: 'delete_favoris')]     
    public function deleteFavorite(Music $music, ManagerRegistry $doctrine)     
    {         
        $music->removeFavorite($this->getUser());          
        $em = $doctrine->getManager();         
        $em->persist($music);         
        $em->flush();         
            return $this->redirectToRoute('app_music');     
        }        
}
