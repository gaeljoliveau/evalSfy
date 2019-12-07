<?php

namespace App\DataFixtures;

use App\Entity\Exhibition;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ExhibitionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for($i = 0; $i <5; $i++){
        $exhibition = new Exhibition();
        $faker = Factory::create('fr_FR');

        $exhibition
            ->setName($faker->unique()->sentence(3))
            ->setPlace($faker->unique()->sentence(4))
            ->setDescription($faker->text)
            ->setDate($faker->dateTime);

        $manager->persist($exhibition);
    }
        for($i = 0; $i <10; $i++){
            $exhibition = new Exhibition();
            $faker = Factory::create('fr_FR');

            $exhibition
                ->setName($faker->unique()->sentence(3))
                ->setPlace($faker->unique()->sentence(4))
                ->setDescription($faker->text)
                ->setDate($faker->dateTimeBetween('now','+5 years', null));

            $manager->persist($exhibition);
        }
        $manager->flush();
    }
}
