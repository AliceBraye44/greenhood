<?php

namespace App\DataFixtures;

use App\Entity\HeatMap;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class HeatMapFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        include "HeatMapCoord.php";
        
        foreach ($data as $point) {
            $heatMap = new HeatMap();
            $heatMap->setRef($point["id"]);
            $heatMap->setCoordX($point["marker"]["long"]);
            $heatMap->setCoordY($point["marker"]["lat"]);
            $manager->persist($heatMap);
        }

        $manager->flush();
    }
}
