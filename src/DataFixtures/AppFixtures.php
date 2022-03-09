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

        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setName($faker->name());
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            $user->setPhone($faker->numberBetween($min = 1100000000, $max = 1999999999));
            $user->setCompany($faker->Company());
            $manager->persist($user);
        }

        for ($i = 1; $i <= 5; $i++) {
            $address = new Address();
            $address->setBillingAddress($faker->address());
            $address->setDeliveryAddress($faker->address());
            $address->setZipCodeDelivery($faker->numberBetween($min = 10000, $max = 99999));
            $address->setZipCodeBilling($faker->numberBetween($min = 10000, $max = 99999));
            $address->setCityDelivery($faker->city());
            $address->setCityBilling($faker->city());
            $manager->persist($address);
        }

        $manager->flush();
    }
}
