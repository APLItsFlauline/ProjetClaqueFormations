<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 10; $i++) {

            $user = new User();
            $user->setUsername($faker->name());
            $user->setEmail($faker->email);
            $user->setPassword($faker->password());
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName);
            $user->setPromo($faker->year());
            $user->setRoles([]);
            $user->setIsTeacher($faker->boolean());

            $manager->persist($user);
        }

        $manager->flush();
    }
}
