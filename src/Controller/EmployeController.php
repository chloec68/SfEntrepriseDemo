<?php

namespace App\Controller;

use App\Controller\EmployeController;
use App\Repository\EmployeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    public function index(EmployeRepository $employeRepository): Response
    {
        $employes = $employeRepository->findAll();
        return $this->render('employe/index.html.twig', [
            'employes' => $employes
        ]);
    }

    // public function index(EmployeRepository $employeRepository): Response
    // {
    //     $employes = $employeRepository->findBy([],['nom'=>'ASC']);
    //     return $this->render('employe/index.html.twig', [
    //         'employes' => $employes
    //     ]);
    // }
}
