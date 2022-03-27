<?php

namespace App\Service;
use App\Service\PerimeterCalculation;
use App\Service\CallApiService;
use App\Repository\CriteriaRepository;
use Location\Coordinate;
use Location\Polygon;



class ApiComparison
{

    function letSCalculate(
        CriteriaRepository $criteriaRepository,
        PerimeterCaluculation $perimeterCalculation,
        CallApiService $callApi,
        $initialAdress
        ) {

        $allCriterias = $criteriaRepository->findAll();
        
        foreach ($allCriterias as $criteria) {

            //Creation d'un tableau de réponses positives
            $matches = [];

            //Définition du périmetre de comparaison
            $areaToCompare = $perimeterCalculation->getArea($initialAdress, $criteria->getId());
           
            //Définition du perimetre à comparer 
            $polygonToCompare = new Polygon();

            foreach ($areaToCompare as $coordinate) {
                $polygonToCompare->addPoint(new Coordinate($coordinate));
            }
        
            //Appel de l'api 
            $results = $callApi->getDataApi($criteria->getData());

            //Comparaison de l'ensemble des records 
            foreach ($results as $key => $value) {
                
                $coordX = $value["gemoetry"]["coordinates"][0];
                $coordY = $value["gemoetry"]["coordinates"][1];
                
                // Stockage des coordonnées des items de l'Api à fin de comparaison
                $itemsCoordinate = new Coordinate($coordX, $coordY);
                
                // si l'item est inclus dans le perimetre de recherche, ajout de l'items à la liste des résultats positifs 
                if( $polygonToCompare->contains($itemsCoordinate) ){
                    array_push($matches, [$cordX, $coordY]);
                }
            }

            // Décompte des résultats positifs
            $numberOccurences = count($matches);

            // Comparaison du score avec l'indice de référence 
            $score = $criteria->getIndexReference()/$numberOccurences;

        }

    }

// 7. On effectue le calcul de critère 
// 8. on retourne :
//     1. une note 
//     2. un tableau de coordonnées trouvées avec les items
//     3. le pin associé

}