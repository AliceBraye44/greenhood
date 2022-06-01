<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\ApiComparison;
use Location\Coordinate;
use Location\Polygon;


class CalculatorController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    #[Route('/calculator', name: 'app_calculator', methods: ['GET', 'HEAD'])]
    public function index(
        ApiComparison $apiComparison, 
        int $status = 200, 
        array $headers = [], 
        string $initialAdress = "27 Bd de Stalingrad, 44041 Nantes"
        ): Response
    {
        $results = $apiComparison->letSCalculate($initialAdress);

        return new Response(
            $this->serializer->serialize($results, JsonEncoder::FORMAT),
            $status,
            array_merge($headers, ['Content-Type' => 'application/json;charset=UTF-8'])
        );
    }
}
