<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')] //ici on peut changer le name, mais /!\ il faut que le name soit unique
    // public function index(EntityManagerInterface $entityManager): Response
    // {
    //     $entreprises = $entityManager->getRepository(Entreprise::class)->findAll(); 
    //     return $this->render('entreprise/index.html.twig', [
    //        'entreprises'=>$entreprises
    //     ]); // ici a été créé un argument par défaut qui montre comment un argument est passé du controller à la vue ;
    // }

    // public function index(EntrepriseRepository $entrepriseRepository):Response{
    //     $entreprises = $entrepriseRepository->findAll();
    //     return $this->render('entreprise/index.html.twig', [
    //         'entreprises'=> $entreprises
    //     ]);
    // }

    public function index(EntrepriseRepository $entrepriseRepository):Response{
        $entreprises = $entrepriseRepository->findBy([],["raisonSociale"=> "ASC"]);
        return $this->render('entreprise/index.html.twig', [
            'entreprises'=> $entreprises
        ]);
    }

    //SELECT * FROM entreprise WHERE ville = 'STRASBOURG' ORDER BY raisonSociale

    // public function index(EntrepriseRepository $entrepriseRepository):Response{
    //     $entreprises = $entrepriseRepository->findBy(['ville'=>'STRASBOURG'],["raisonSociale"=> "ASC"]);
    //     return $this->render('entreprise/index.html.twig', [
    //         'entreprises'=> $entreprises
    //     ]);
    // }
   
    #[Route('/entreprise/{id}', name: 'display_info')]
        public function displayInfo(Entreprise $entreprise):Response{


            return $this->render('entreprise/displayInfo.html.twig', [
                'entreprise'=> $entreprise
            ]);
    }
}
