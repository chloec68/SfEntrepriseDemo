<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use App\Form\EntrepriseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/entreprise/new', name: 'new_entreprise')]
    #[Route('/entreprise/{id}/edit', name: 'edit_entreprise')]
    public function new_edit(Request $request, EntityManagerInterface $entityManager, ?Entreprise $entreprise = null): Response
    // ?Entreprise => comme entreprise peut être nulle (pas encore créée), il faut le définir exmplicitement ;
    // ? => indique à PHP qu' $entreprise peut être soit une instance d'Entreprise ou être nulle 
    {   
        if(!$entreprise){
            $entreprise = new Entreprise();
        }

        $form = $this->createForm(EntrepriseType::class, $entreprise);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entreprise = $form->getData();

            $entityManager->persist($entreprise); // équivalent $pdo->prepare

            $entityManager->flush(); // équivalent $pdo->execute

            return $this->redirectToRoute('app_entreprise');
        }

        return $this->render('entreprise/new.html.twig', [
            'formNewEntreprise'=>$form,
            'edit' => $entreprise->getId() // si l'entreprise est déjà créée, un id est renvoyé (renvoie bool:true) / sinon bool:false
        ]);
    }

    #[Route('/entreprise/{id}/delete', name: 'delete_entreprise')]
    public function delete(Entreprise $entreprise,EntityManagerInterface $entityManager){
        if($entreprise){
            $entityManager->remove($entreprise);
            $entityManager->flush();
        }
    }
   
    #[Route('/entreprise/{id}', name: 'display_entreprise')]
        public function displayInfo(Entreprise $entreprise):Response{


            return $this->render('entreprise/displayEntreprise.html.twig', [
                'entreprise'=> $entreprise
            ]);
        }
 
}
