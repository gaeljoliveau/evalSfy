<?php

namespace App\DataFixtures;


use App\Entity\Artwork;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory as Faker;

class ArtworkFixtures extends Fixture implements OrderedFixtureInterface
{

    public $categories = ["paintCategory", "drawingCategory", "sculptureCategory"];

    public function load(ObjectManager $manager)
    {
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $artwork = new Artwork();

            $artwork
                ->setName($faker->unique()->sentence(3))
                ->setDescription($faker->text)
                ->setPicture($faker->image('public/img/artwork/', 1920, 1080, null, false));

            $randomCategoryIndex = random_int(0, count($this->categories) - 1);
            $artwork->setCategory($this->getReference($this->categories[$randomCategoryIndex]));

            $manager->persist($artwork);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

}