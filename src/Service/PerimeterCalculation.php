<?php

namespace App\Service;
use App\Service\TransformAdressGeo;
use App\Entity\Criteria;
use App\Repository\CriteriaRepository;


class PerimeterCalculation
{

    function getArea(
        $initialAdress, 
        $id,
        TransformAdressGeo $adress,
        CriteriaRepository $criteriaRepository
        ) : array {

        // Récupération de l’adresse par methode POST
        $initialAdress; 
    
        // Transformation de l’adresse en coordonnées GPS 
        $initialCoordinates = $adress->geocodeAddress($initialAdress);
    
        //Récupération du perimetre du critère en BDD 
        $criteriaPerimeter = $criteriaRepository->findOnebyId($id)->getPerimeter();
       
        //Transformation des coordonnées en fonction du perimetre de la bdd // a définir 

        //valeur de retour, tableau de tableau avec à minima 4 paires de coordonnées de type '(integer, integer)'

        return $areaToCompare;
    }

}
