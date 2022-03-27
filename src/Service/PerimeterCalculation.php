<?php

namespace App\Service;
use App\Service\TransformAdressGeo;
use App\Entity\Criteria;
use App\Repository\CriteriaRepository;


class PerimeterCalculation
{

    function getPerimeter(TransformAdressGeo $adress, $initialAdress){

        // Récupération de l’adresse par method POST
        $initialAdress; 
    
        // Transformation de l’adresse en coordonnées GPS 
        $coordinates = $adress->geocodeAddress($initialAdress);
    
        // Utilisation d’une methode qui prends en paramètre les coordonnées et une injection de dépendance du critère de la bdd. 
        return $areaToCompare = $this.getArea();


        
        // 1. récupère en bdd le périmètre du critère 
        // 2. on transforme les coordonnées rentrés en paramètre en un périmètre   
    }

    function getArea($coordinates, CriteriaRepository $criteriaRepository, $id ){

        //Récupération du perimetre du critère en BDD 
        $criteriaPerimeter = $criteriaRepository->findOnebyId($id)->getPerimeter();

        //Transformation des coordonnées 
        


    }



}
