<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    public const CATEGORY = [
        ['name' => 'Catégorie 1', 'image' => 'https://img.lemde.fr/2021/07/03/0/0/4800/3200/664/0/75/0/c892f49_581229870-le-naufrage-de-neptune-ugo-schiavi-place-royale-le-voyage-a-nantes-2021-martin-argyroglo-lvan-6.jpg'],
        ['name' => 'Catégorie 2', 'image' => 'https://img.lemde.fr/2021/07/03/0/0/4800/3200/664/0/75/0/c892f49_581229870-le-naufrage-de-neptune-ugo-schiavi-place-royale-le-voyage-a-nantes-2021-martin-argyroglo-lvan-6.jpg'],
        ['name' => 'Catégorie 3', 'image' => 'https://img.lemde.fr/2021/07/03/0/0/4800/3200/664/0/75/0/c892f49_581229870-le-naufrage-de-neptune-ugo-schiavi-place-royale-le-voyage-a-nantes-2021-martin-argyroglo-lvan-6.jpg'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORY as $key => $categoryInfos) {
            $category = new Category();
            $category->setName($categoryInfos['name']);
            $category->setImage($categoryInfos['image']);
            $manager->persist($category);

            $this->addReference('category_' . $key, $category);

            $manager->flush();
        }
    }

}
