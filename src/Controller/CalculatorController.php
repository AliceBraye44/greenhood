<?php

namespace App\Controller;

use Location\Polygon;
use Location\Coordinate;
use App\Service\Calculator;
use App\Controller\AppController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CalculatorController extends AppController
{
    
    public function __construct(
        private SerializerInterface $serializer, 
        private Calculator $calculator )
    {
    }

    
    // Méthode permettant de calculer le score par adresse postale
    #[Route('/calculator', name: 'app_calculator', methods: ['GET', 'HEAD'])]
    public function index(
        int $status = 200, 
        array $headers = [], 
        ): JsonResponse
    {
        // Récupération de l'adresse envoyé par le front ou utilisation d'une adresse générique
        $initialAdress = $this->getInitialAdress();
        // Calcul des notes par critère et note globale via le Service Calculator
        $results = $this->calculator->calculByAdress($initialAdress);
    
        return $this->json($results);
    
    }

    #[Route('/calculator/heatMap', name: 'app_calculator_heatmap', methods: ['GET', 'HEAD'])]
    public function heatmap(
        int $status = 200, 
        array $headers = [], 
        HeatMapRepository $heatMapRepository
        ): JsonResponse
    {

        // Calcul des notes pour l'ensemble des notes des points de la heatmap qui mettra à jour la BDD
        $this->calculator->calculHeatMap();

        // Récupération des résultats
        $heatMapResults = $this->heatMapRepository->findAll(); 

        // Retour au format json des résultats 
        return $this->json($heatMapResults);
    
    }

}
