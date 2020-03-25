<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');
        // $product = new Product();
        // $manager->persist($product);

        // Gestion des utilisateurs
        $users = [];
        $genres = ['male', 'female'];

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();

            $genre = $faker->randomElement($genres);

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setHash($hash);

            $manager->persist($user);
            $users[] = $user;
        }

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
