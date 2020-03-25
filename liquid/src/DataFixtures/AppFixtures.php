<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');
        // $product = new Product();
        // $manager->persist($product);

        //Gestion des evenement
        for ($i = 1; $i < 30; $i++) {
            $event = new Event();

            $name = $faker->sentence();
            $date = $faker->date();

            $event->setName($name)
                ->setDate($date);

            $manager->persist($event);
        }

        $manager->flush();
    }
}
