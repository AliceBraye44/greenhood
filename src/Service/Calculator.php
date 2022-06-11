<?php

namespace App\Service;

use App\Repository\CriteriaRepository;
use App\Repository\HeatMapRepository;
use App\Service\CallApiService;
use App\Service\TransformAdressGeo;
use Location\Coordinate;
use Location\Distance\Haversine;
use Doctrine\Persistence\ObjectManager;
use DateTime;



class Calculator
{
    public function __construct(
        private CriteriaRepository $criteriaRepository,
        private TransformAdressGeo $adress,
        private CallApiService $callApi,
        private HeatMapRepository $heatMapRepository,
    ) {}

    /* RESTE A FAIRE 01/06/2022:
     *
     * Vérifier les distances calculé pat Haversine de PHPGEO
     *
     */

    // Méthode générale permettant de calculer la note globale et détaillée d'une adresse
    public function calculByAdress($initialAdress)
    {

        // Transformation de l’adresse en coordonnées GPS
        $coordinates = $this->adress->geocodeAddress($initialAdress);
        // Calacul des résultats avec les coordonnnées issues de l'adresse
        $resultsByCriteria = $this->calculByCriteria($coordinates);
        // Calcul de la note globale
        $globalNote = $this->calculGlobalNotation($resultsByCriteria);

        return ["globalNote" => $globalNote, "allResults" => $resultsByCriteria];
    }

    
    // Méthode permettant de cacluer par critère la note attribuée et de renvoyer l'ensemble des coordonnées
    public function calculByCriteria(
        $coordinates) {

        // récupération de tous les critères en base de données
        $allCriterias = $this->criteriaRepository->findAll();

        // initilialisation d'un tableau de résultats vide
        $allResults = [];

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
                // Le résultat est exprimé en metre
                $distance = $coordinatesToCompare->getDistance($itemCoordinates, new Haversine());

                // WARNING pas le résulat escompté ni avec Vincenty ni avec Haversine

                // si l'item est inclus dans le perimetre de recherche, ajout de l'items à la liste des résultats positifs
                if ($distance < $criteria->getPerimeter()) {
                    array_push($matches, [$coordX, $coordY]);
                }

            }

            // Décompte des résultats positifs
            $numberOccurences = count($matches);

            if ($numberOccurences > 0) {

                // Comparaison du score avec l'indice de référence
                $score = ($numberOccurences / $criteria->getIndexReference()) * 50;

                //retourne un tableau par critère incluant : le nom du critère, le score, le tableau de matchs avec les coordonnées, le pin associé
                $returnByCriteria = ["id" => $criteria->getId(), "name" => $criteria->getName(), "score" => $score, "itemsCoord" => $matches, "pin" => $criteria->getPin()];

                array_push($allResults, $returnByCriteria);
            } else {
                array_push($allResults, [
                    "id" => $criteria->getId(),
                    "name" => $criteria->getName(),
                    "score" => 0,
                    "itemsCoord" => [],
                ]);

            }

        }

        return $allResults;
    }

    // Calcul global de la note prenant en considération les coefficients attribués aux critères
    // Paramètre d'entrée : resultat de la méthode calculByCriteria
    public function calculGlobalNotation($criteriaNotation)
    {

        // Initialisation des totaux des notes
        $totalNotation = 0;
        // Intiliation des coefficients totaux
        $totalCoefficient = 0;

        // Boucle sur l'ensemble du tableau, récupérer id et score
        foreach ($criteriaNotation as $criteriaNoted) {
            //Récupération du critère dans la base de donnée, ciblé par id
            $criteria = $this->criteriaRepository->find($criteriaNoted['id']);
            // Récupération du coefficient
            $coefficent = $criteria->getCoefficient();
            // Récupération de la note attribué au critère
            $score = $criteriaNoted['score'];

            // Calcul de la note pondéré et ajout à la note globale
            $totalNotation = $totalNotation + ($score * $coefficent);
            // Irrigation du coefficient global
            $totalCoefficient = $totalCoefficient + $coefficent;

        }

        // Calcul de la note globale
        $globalNotation = round($totalNotation / $totalCoefficient, 0, PHP_ROUND_HALF_EVEN);

        // Retourner la note globale
        return $globalNotation;
    }
}
