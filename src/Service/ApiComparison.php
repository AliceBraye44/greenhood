<?php

namespace App\Service;
use App\Service\CallApiService;
use App\Service\TransformAdressGeo;
use App\Repository\CriteriaRepository;
use Location\Coordinate;
use Location\Distance\Haversine;



class ApiComparison
{
    public function __construct(
        private CriteriaRepository $criteriaRepository,
        private TransformAdressGeo $adress,
        private CallApiService $callApi,
    ){}
    

    function letSCalculate(
        $initialAdress
        ) {

        // récupération de tous les critères en base de données 
        $allCriterias = $this->criteriaRepository->findAll();

        // initilialisation d'un tableau de résultats vide
        $allResults = [];

        // TODO Récupération de l’adresse par methode POST
        $initialAdress; 

        // Transformation de l’adresse en coordonnées GPS 
        $coordinates = $this->adress->geocodeAddress($initialAdress);

        // boucle sur chacun des critères 
        foreach ($allCriterias as $criteria) {

            //Creation d'un tableau de réponses positives par critère
            $matches = [];
           
            // Transformation des coordonnées GPS en cordonnées exploitatables par phpgeo
            $coordinatesToCompare = new Coordinate($coordinates[0], $coordinates[1]); 

            //Appel de l'api 
            $results = $this->callApi->getDataApi($criteria->getData())["records"];

            //Comparaison de l'ensemble des records du critère 
            foreach ($results as $value) {

                $coordX = $value["geometry"]["coordinates"][0];
                $coordY = $value["geometry"]["coordinates"][1];
                
                // Stockage des coordonnées des items de l'Api à fin de comparaison
                $itemCoordinates = new Coordinate($coordX, $coordY);
                
                // Comparaison des deux coordonnées pour en obtenir la distance grâce à la formule Vincenty (phpgeo)
                // $calculator = new Vincenty();
                // $distance = $calculator->getDistance($coordinatesToCompare, $itemCoordinates);

                $distance = $coordinatesToCompare->getDistance($itemCoordinates, new Haversine());

                // //le résultat est exprimé en metre  
                // WARNING pas le résulat escompté ni avec Vincenty ni avec Haversine 
        
                // si l'item est inclus dans le perimetre de recherche, ajout de l'items à la liste des résultats positifs 
                if( $distance < $criteria->getPerimeter() ) {
                    array_push($matches, [$coordX, $coordY]);
                } 
            }
            
            // Décompte des résultats positifs
            $numberOccurences = count($matches);

            if($numberOccurences > 0 ){

                // Comparaison du score avec l'indice de référence 
                $score = ($numberOccurences/$criteria->getIndexReference())*50;
    
                //retourne un tableau par critère incluant : le nom du critère, le score, le tableau de matchs avec les coordonnées, le pin associé
                $returnByCriteria = ["name" => $criteria->getName(), "score" => $score,  "itemsCoord" => $matches, "pin" => $criteria->getPin()];
    
                array_push($allResults, $returnByCriteria);
            }


        }

        //array_push($allResults, $returnByCriteria);
        dd($allResults);


    }

}