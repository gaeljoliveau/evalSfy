<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {


        $category = new Category();
        $category->setName("Peinture");

        // créer une référence pour mettre en relation les entités : mise en mémoire de l'instance
        $this->addReference("paintCategory", $category);

        $manager->persist($category);


        $category2 = new Category();
        $category2->setName("Dessin");

        // créer une référence pour mettre en relation les entités : mise en mémoire de l'instance
        $this->addReference("drawingCategory", $category2);

        $manager->persist($category2);


        $category3 = new Category();
        $category3->setName("Sculpture");

        // créer une référence pour mettre en relation les entités : mise en mémoire de l'instance
        $this->addReference("sculptureCategory", $category3);

        $manager->persist($category3);


        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}