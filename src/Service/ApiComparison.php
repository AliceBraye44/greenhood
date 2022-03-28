<?php

namespace App\Service;
use App\Service\PerimeterCalculation;
use App\Service\CallApiService;
use App\Service\TransformAdressGeo;
use App\Repository\CriteriaRepository;
use Location\Coordinate;
use Location\Distance\Vincenty;



class ApiComparison
{

    function letSCalculate(
        CriteriaRepository $criteriaRepository,
        TransformAdressGeo $adress,
        CallApiService $callApi,
        $initialAdress
        ) {

        $allCriterias = $criteriaRepository->findAll();

        $allResults = [];
        
        foreach ($allCriterias as $criteria) {

            //Creation d'un tableau de réponses positives
            $matches = [];

            // TODO Récupération de l’adresse par methode POST
            $initialAdress; 
    
            // Transformation de l’adresse en coordonnées GPS 
            $coordinatesToCompare = $adress->geocodeAddress($initialAdress);
           
            // Transformation des coordonnées GPS en cordonnées exploitatable par phpgeo
            $coordinatesToCompare = new Coordinate($coordinatesToCompare[0], $coordinatesToCompare[1]); 

            //Appel de l'api 
            $results = $callApi->getDataApi($criteria->getData());

            //Comparaison de l'ensemble des records 
            foreach ($results as $key => $value) {
                
                $coordX = $value["gemoetry"]["coordinates"][0];
                $coordY = $value["gemoetry"]["coordinates"][1];
                
                // Stockage des coordonnées des items de l'Api à fin de comparaison
                $itemCoordinates = new Coordinate($coordX, $coordY);

                // Comparaison des deux coordonnées pour en obtenir la distance grâce à la formule Vincenty (phpgeo)
                $calculator = new Vincenty();
                $distance = $calculator->getDistance($coordinatesToCompare, $itemCoordinates);
                //TODO vérifier les mesures du resultat 
        
                // si l'item est inclus dans le perimetre de recherche, ajout de l'items à la liste des résultats positifs 
                if( $distance < $criteria->getPerimeter() ) {
                    array_push($matches, [$cordX, $coordY]);
                }
                
            }

            // Décompte des résultats positifs
            $numberOccurences = count($matches);

            // Comparaison du score avec l'indice de référence // A ettofer
            $score = $criteria->getIndexReference()/$numberOccurences;

            //retourne un tableau par critère incluant : le nom du critère, le score, le tableau de matchs avec les coordonnées, le pin associé
            $returnByCriteria = [" name" => $criteria->getName(), "score" => $score,  "itemsCoord" => $matches, "pin" => $criteria->getPin()];
            
            return $returnByCriteria;
               
        }

        array_push($allResults, $returnByCriteria);


    }

}