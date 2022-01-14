<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use App\Entity\User;
use phpDocumentor\Reflection\Types\String_;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 50; $i++) {

            $firstName=$faker->firstName();
            $lastName=$faker->lastName;
            $year=$faker->year();

            if ($year<=2022) {
                $mail = 'marseille';
            }
            else {
                $mail = 'mediterranee';
            }

            $user = new User();
            $user->setUsername($firstName.$lastName); // Y'a un pb : $firstName[0] marche pas alors que c'est bien un string.
            //                                                 Doit y avoir un pb avec faker, avec des strings normaux ça passe
            $user->setEmail($firstName.'.'.$lastName.'@centrale-'.$mail.'.fr'); // Je fais en prévision de Centrale Mediterranee
            $user->setPassword($faker->password());
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setPromo($year);
            $user->setRoles([]);
            $user->setIsTeacher($faker->boolean());

            $manager->persist($user);
        }

        $manager->flush();
    }
}
