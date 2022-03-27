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
            'name' => 'Critère 1',
            'data' => 'https://data.nantesmetropole.fr/api/records/1.0/search/?dataset=244400404_decheteries-ecopoints-nantes-metropole',
            'index_reference' => '5',
            'scale' => '100',
            'coefficient' => '3',
            'methodology' => 'blablabla',
            'pin' => '<i class="fa-solid fa-trash-arrow-up"></i>'],
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