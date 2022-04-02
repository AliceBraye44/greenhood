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
    // #[Route('/home', name: 'app_home')]
    // public function index(CallApiService $callApi, TransformAdressGeo $transformAdress): Response
    // {
    //     dd($callApi->getDataApi());
    //     $transformAdress->geocodeAddress();
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }

    // #[Route('/phpgeo', name: 'phpgeo')]
    // public function phpgeo(): Response
    // {
    //     $geofence = new Polygon();

    //     $geofence->addPoint(new Coordinate(-12.085870,-77.016254));
    //     $geofence->addPoint(new Coordinate(-12.085870,-77.016278));
    //     $geofence->addPoint(new Coordinate(-12.085870,-77.016261));
    //     $geofence->addPoint(new Coordinate(-12.086373,-77.033813));
    //     $geofence->addPoint(new Coordinate(-12.102823,-77.030938));
    //     $geofence->addPoint(new Coordinate(-12.098669,-77.006476));

    //     $outsidePoint = new Coordinate(-12.075452, -76.985079);
    //     $insidePoint = new Coordinate(-12.092542, -77.021540);

    //     var_dump( $geofence->contains($outsidePoint)
    //         ? 'Point 1 is located inside the polygon' . PHP_EOL
    //         : 'Point 1 is located outside the polygon' . PHP_EOL);

    //     var_dump($geofence->contains($insidePoint)
    //         ? 'Point 2 is located inside the polygon' . PHP_EOL
    //         : 'Point 2 is located outside the polygon' . PHP_EOL);

    //         return $this->render('home/index.html.twig', [
    //             'controller_name' => 'HomeController',
    //         ]);
    //     }
}

