<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

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
                ->setCreatedAt($faker->dateTimeBetween('-6 months'));

            $manager->persist($owner);
        }

        $manager->flush();
    }
}
