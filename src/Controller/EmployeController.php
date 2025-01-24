<?php

namespace App\Controller;

use App\Controller\EmployeController;
use App\Repository\EmployeRepository;
use App\Entity\Employe;
use App\Form\EmployeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    // public function index(EmployeRepository $employeRepository): Response
    // {
    //     $employes = $employeRepository->findAll();
    //     return $this->render('employe/index.html.twig', [
    //         'employes' => $employes
    //     ]);
    // }

    public function index(EmployeRepository $employeRepository): Response
    {
        $employes = $employeRepository->findBy([],['nom'=>'ASC']);
        return $this->render('employe/index.html.twig', [
            'employes' => $employes
        ]);
    }

    #[Route('/employe/new', name: 'new_employe')]
    #[Route('/employe/{id}/edit', name: 'edit_employe')]
    public function new_edit(Request $request, EntityManagerInterface $entityManager, ?Employe $employe = null): Response
    {
        if(!$employe){
            $employe = new Employe();
        }
        
        $form = $this->createForm(EmployeType::class, $employe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $employe = $form->getData();

            $entityManager->persist($employe); // équivalent $pdo->prepare

            $entityManager->flush(); // équivalent $pdo->execute

            return $this->redirectToRoute('app_employe');
        }

        return $this->render('employe/new.html.twig', [
            'formNewEmploye'=>$form,
        ]);
    }
   
    #[Route('/entreprise/{id}', name: 'display_entreprise')]
        public function displayInfo(Entreprise $entreprise):Response{


            return $this->render('entreprise/displayEntreprise.html.twig', [
                'entreprise'=> $entreprise
            ]);
    }

    #[Route('/employe/{id}', name: 'display_employe')]
    public function displayEmploye(Employe $employe): Response
    {
        return $this->render('employe/displayEmploye.html.twig', [
            'employe' => $employe
        ]);
    }

    #[Route('/employe/{id}/delete', name: 'delete_employe')]
    public function delete(Employe $employe){
        
    }
}
