<?php

namespace App\Controller;

use App\Service\Calculator;
use App\Controller\AppController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



#[Route('/admin/search')]
class SearchController extends AppController
{
    #[Route('/', name: 'app_search', methods: ['GET'])]
    public function index( Calculator $calculator): Response
    {
        // Récupération de l'adresse envoyé par l'espace admin
        $initialAdress = $this->getInitialAdress();
        // Calcul des notes par critère et note globale via le Service Calculator
        $results = $calculator->calculByAdress($initialAdress);

        return $this->render('search/index.html.twig', [
            'notes' => $results, 
            'adress' => $initialAdress
        
        ]);
    }
}