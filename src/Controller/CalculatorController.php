<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\Calculator;
use Location\Coordinate;
use Location\Polygon;


class CalculatorController extends AbstractController
{
    
    public function __construct(private SerializerInterface $serializer)
    {
    }

    
    // Méthode permettant de calculer le score par adresse postale
    #[Route('/calculator', name: 'app_calculator', methods: ['GET', 'HEAD'])]
    public function calculByAdress(
        Calculator $calculator, 
        int $status = 200, 
        array $headers = [], 
        string $initialAdress = "27 Bd de Stalingrad, 44041 Nantes"
        ): Response
    {
        $resultsByCriteria = $calculator->calculByCriteria($initialAdress);
        $globalNote = $calculator->calculGlobalNotation($resultsByCriteria);

        return new Response(
            $this->serializer->serialize([ "globalNote" => $globalNote, "allResults" => $resultsByCriteria], JsonEncoder::FORMAT),
            $status,
            array_merge($headers, ['Content-Type' => 'application/json;charset=UTF-8'])
        );
    }


    // Méthode permettant de receptionner l'adresse envoyé par le front
    #[Route('/calculator/adress', name: 'app_calculator_adress', methods: ['GET'])]
    public function adress(){

        // Vérifier si le formulaire est soumis 
        if ( isset( $_GET['submit'] ) ) {
            return  $_GET['adress']; 
        }
    }

}
