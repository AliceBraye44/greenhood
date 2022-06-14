<?php

namespace App\Controller;

use App\Service\Calculator;
use App\Controller\AppController;
use App\Repository\HeatMapRepository;
use App\Repository\CriteriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\CallApiService;


class CalculatorController extends AppController
{

    public function __construct(
        private SerializerInterface $serializer,
        private Calculator $calculator) {
    }

    // Méthode permettant de calculer le score par adresse postale
    #[Route('/calculator', name:'app_calculator', methods:['GET', 'HEAD'])]
function index(
    int $status = 200,
    array $headers = [],
): JsonResponse {
    // Récupération de l'adresse envoyé par le front ou utilisation d'une adresse générique
    $initialAdress = $this->getInitialAdress();
    // Calcul des notes par critère et note globale via le Service Calculator
    $results = $this->calculator->calculByAdress($initialAdress);

    return $this->json($results);

}

#[Route('/calculator/heatMap', name:'app_calculator_heatmap', methods:['GET', 'HEAD'])]
function heatmaCalcul(
    HeatMapRepository $heatMapRepository,
    CriteriaRepository $criteriaRepository,
    EntityManagerInterface $entityManager, 
    CallApiService $callApi,
) {
    //Récupération de l'ensemble des coordonnées
    $heatMap = $heatMapRepository->findAll();
    
    // récupération de tous les critères en base de données
    $allCriterias = $criteriaRepository->findAll();

    // boucle sur tous les critères pour stocker le résultat de l'appel d'api 
    $allResultsApi = [] ; 

    foreach ($allCriterias as $criteria) {
        //Appel de l'api
        $results = $callApi->getDataApi($criteria->getData())["records"];
        array_push( $allResultsApi, $results);
    }

    //Boucle sur l'ensemble des points
    foreach ($heatMap as $key => $pointMap) {

        // Calcul pour chacun des critères
        $resultsByCriteria = $this->calculator->calculByCriteriaForHeatMap([$pointMap->getCoordX(), $pointMap->getCoordY()], $allCriterias, $allResultsApi);

        // Calcul de la note globale
        $globalNote = $this->calculator->calculGlobalNotation($resultsByCriteria);

        //$pointToUpdate = $heatMapRepository->find($pointMap->getId());
        $heatMapRepository->updatePoint($pointMap->getId(), $globalNote, $resultsByCriteria);

    }

    return ("ok");
}

// route pour récupérer les données de la base et les envoyer au front
#[Route('/heatMap', name:'app_result_heatmap', methods:['GET', 'HEAD'])]
function heatmapResult(
    HeatMapRepository $heatMapRepository
): JsonResponse {

    // Récupération des résultats
    $heatMap = $heatMapRepository->findAll();

    // Retour au format json des résultats
    return $this->json($heatMap);
}

}
