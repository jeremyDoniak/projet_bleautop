<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Address;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create();

        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setName($faker->name());
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            $manager->persist($user);
        }

        for ($i = 1; $i <= 5; $i++) {
            $address = new Address();
            $address->setAddress1($faker->address());
            $address->setAddress2($faker->address());
            $address->setZipCode($faker->postcode());
            $address->setCity($faker->city());
            $manager->persist($address);
        }

        $manager->flush();
    }
}
