<?php

namespace App\tests\Service; 
use App\Service\TransformAdressGeo;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TransformAdressGeoTest extends KernelTestCase 
{
    public function testCoordinate(){    
        self::bootKernel();
        $container = static::getContainer();
        $adressTransformer = $container->get(TransformAdressGeo::class);
        $this->assertEquals([-1.537285, 47.219001], $adressTransformer->geocodeAddress('27 Bd de Stalingrad, 44041 Nantes'));
    }
}