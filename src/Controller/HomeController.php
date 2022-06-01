<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CallApiService;
use App\Service\TransformAdressGeo;
use Location\Coordinate;
use Location\Polygon;


class HomeController extends AbstractController
{

    #[Route("/", name: "app_home")]
    public function index(): Response
    {
        // Permet de rediriger immédiatement vers le login si pas connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        return $this->render('index.html.twig', [
        ]);
    }
    
}

