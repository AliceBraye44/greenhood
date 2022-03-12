<?php

namespace App\DataFixtures;

use App\Entity\Criteria;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

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
            $criteria->setCategory($criteriaInfos[($this->getReference('name'. $category))]);
            $criteria->setName($criteriaInfos['name']);
            $criteria->setData($criteriaInfos['data']);
            $criteria->setIndexReferencetData($criteriaInfos['index_reference']);
            $criteria->setScale($criteriaInfos['scale']);
            $criteria->setCoefficient($criteriaInfos['coefficient']);
            $criteria->setMethodology($criteriaInfos['methodology']);
            $criteria->setPin($criteriaInfos['pin']);

            $manager->persist($criteria);
            $manager->flush();
        }
    }
}