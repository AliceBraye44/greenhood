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

        $allResults = [];
        
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
                $itemCoordinates = new Coordinate($coordX, $coordY);
                
                // si l'item est inclus dans le perimetre de recherche, ajout de l'items à la liste des résultats positifs 
                if( $polygonToCompare->contains($itemCoordinates) ){
                    array_push($matches, [$cordX, $coordY]);
                }
            }

            // Décompte des résultats positifs
            $numberOccurences = count($matches);

            // Comparaison du score avec l'indice de référence // A ettofer
            $score = $criteria->getIndexReference()/$numberOccurences;

            //retourne un tableau par critère incluant : le nom du critère, le score, le tableau de matchs avec les coordonnées, le pin associé
            $returnByCriteria = [$criteria->getName(), $score,  $matches, $criteria->getPin()];
            
            return $returnByCriteria;
               
        }

        array_push($allResults, $returnByCriteria);


    }

}