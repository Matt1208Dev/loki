<?php

namespace App\DataFixtures;

use App\Entity\Apartment;
use App\Entity\Owner;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($o = 0; $o < 20; $o++) {
            $owner = new Owner;
            $owner->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setStreet($faker->streetAddress())
                ->setZip($faker->postcode())
                ->setCity($faker->city())
                ->setPhone($faker->phoneNumber())
                ->setMail($faker->email())
                ->setComment($faker->sentence())
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setRetired(false);

                for ($a = 0; $a < rand(1, 4); $a++) {
                    $apartment = new Apartment;
                    $apartment->setStreet($faker->streetAddress())
                        ->setZip($faker->postcode())
                        ->setCity($faker->city())
                        ->setOwner($owner)
                        ->setCreatedAt($faker->dateTimeBetween('-2 months'))
                        ->setRetired(false);
        
                    $manager->persist($apartment);
                }

            $manager->persist($owner);
        }

        for ($s = 0; $s < 10; $s++) {
            $service = new Service;
            $service->setLabel($faker->word())
                ->setPrice($faker->randomFloat(2, 5, 30));

            $manager->persist($service);
        }

        $manager->flush();
    }
}
