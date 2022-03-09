<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Owner;
use App\Entity\Service;
use App\Entity\Apartment;
use App\Entity\Rent;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class AppFixtures extends Fixture
{
    protected $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new User();

        $hash = $this->encoder->hashPassword($user, "password");

        $user->setEmail("allardphilippe@gmail.com")
            ->setFullName("Philippe Allard")
            ->setPassword($hash)
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        for ($s = 0; $s < 10; $s++) {
            $service = new Service;
            $service->setLabel($faker->word())
                ->setPrice($faker->randomFloat(2, 5, 30))
                ->setRetired(false);

            $manager->persist($service);
        }

        $owners = [];
        for ($o = 0; $o < 10; $o++) {
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

            for ($a = 0; $a < rand(1, 3); $a++) {
                $apartment = new Apartment;
                $apartment->setStreet($faker->streetAddress())
                    ->setZip($faker->postcode())
                    ->setCity($faker->city())
                    ->setOwner($owner)
                    ->setCreatedAt($faker->dateTimeBetween('-2 months'))
                    ->setRetired(false);

                $manager->persist($apartment);

                for ($r = 0; $r < 3; $r++) {
                    $rent = new Rent();
        
                    $rent->setOwner($owner)
                        ->setApartment($apartment)
                        ->setStartingDate($faker->dateTimeBetween('-6 months'))
                        ->setEndingDate($faker->dateTimeBetween($rent->getStartingDate(), '+ 7 days'))
                        ->setRentType($faker->randomElement([$rent::RENT_NORMAL, $rent::RENT_ONLINE]))
                        ->setTotal($faker->randomFloat(2, 50, 1000))
                        ->setIsPaid($faker->boolean(80))
                        ->setDeposit($faker->randomElement([$rent::DEPOSIT_ONLINE, $rent::DEPOSIT_OWNER, $rent::DEPOSIT_PAY_CHEQUE]))
                        ->setComment($faker->sentence(20))
                        ->setCreatedAt($rent->getEndingDate());
                    
                    if ($rent->getIsPaid() === true) {
                        $rent->setSettlementDate($faker->dateTimeBetween('-6 months'));
                    }
        
                    $manager->persist($rent);
                }
            }

            $manager->persist($owner);
        }

        $manager->flush();
    }
}
