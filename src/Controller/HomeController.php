<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CallApiService;
use App\Service\TransformAdressGeo;


class HomeController extends AbstractController
{

    
    
    #[Route('/home', name: 'app_home')]
    public function index(CallApiService $callApi, TransformAdressGeo $transformAdress): Response
    {
        dd($transformAdress->geocodeAddress());
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
