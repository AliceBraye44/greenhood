<?php

namespace App\DataFixtures;

use App\Entity\Criteria;
use App\Entity\Category;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CriteriaFixtures extends Fixture
{

    public const CRITERIA = [
        [
            'name' => 'Déchèteries-écopoints de Nantes Métropole',
            'data' => '244400404_decheteries-ecopoints-nantes-metropole',
            'index_reference' => '5',
            'scale' => '100',
            'coefficient' => '5',
            'methodology' => 'blablabla',
            'pin' => '<i class="fa-solid fa-trash-arrow-up"></i>',
            'perimeter' => 20000
        
        ],
      [
            'name' => 'Composteur de quartier',
            'data' => '512042839_composteurs-quartier-nantes-metropole&q=&facet=categorie&facet=annee&facet=lieu',
            'index_reference' => '5',
            'scale' => '100',
            'coefficient' => '3',
            'methodology' => 'blablabla',
            'pin' => '<i class="fa-solid fa-trash-arrow-up"></i>', 
            'perimeter' => 5000
        ],   
        [
            'name' => 'Parcs et jardins de Nantes',
            'data' => '244400404_parcs-jardins-nantes',
            'index_reference' => '2',
            'scale' => '100',
            'coefficient' => '3',
            'methodology' => 'blablabla',
            'pin' => '<i class="fa-solid fa-trash-arrow-up"></i>', 
            'perimeter' => 4000
        ],
        [
            'name' => 'Stations vélos en libre-service',
            'data' => '244400404_stations-velos-libre-service-nantes-metropole-disponibilites',
            'index_reference' => '7',
            'scale' => '100',
            'coefficient' => '6',
            'methodology' => 'blablabla',
            'pin' => '<i class="fa-solid fa-trash-arrow-up"></i>', 
            'perimeter' => 1000
        ],      
        [
            'name' => 'Structures de ré-emploi ',
            'data' => '818979973_structures-re-emploi-loire-atlantique',
            'index_reference' => '3',
            'scale' => '100',
            'coefficient' => '4',
            'methodology' => 'blablabla',
            'pin' => '<i class="fa-solid fa-trash-arrow-up"></i>', 
            'perimeter' => 10000
        ], 
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self:: CRITERIA as $criteriaInfos) {
            $criteria = new Criteria();
            $criteria->setCategory($this->getReference('category_'.rand(0,2)));
            $criteria->setName($criteriaInfos['name']);
            $criteria->setData($criteriaInfos['data']);
            $criteria->setIndexReference($criteriaInfos['index_reference']);
            $criteria->setScale($criteriaInfos['scale']);
            $criteria->setCoefficient($criteriaInfos['coefficient']);
            $criteria->setMethodology($criteriaInfos['methodology']);
            $criteria->setPin($criteriaInfos['pin']);
            $criteria->setPerimeter($criteriaInfos['perimeter']);

            $manager->persist($criteria);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}