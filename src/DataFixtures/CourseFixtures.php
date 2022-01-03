<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Course;
use App\Entity\User;


class CourseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $repo=$manager->getRepository(User::class);
        $users=$repo->findAll();
        $nbUsers=count($users);

        for($i = 1; $i <= $nbUsers; $i++){

            $course = new Course();
            $course->setCreatedBy($users[$i]);
            $course->setActive($faker->boolean());
            $course->setName($faker->sentence());
            $course->setOpen($faker->boolean());
            for($j=1; $j<=$i;$j++){
                $course->addPerson($users[$j]);
            }

            $manager->persist($course);
        }

        $manager->flush();

    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
            ];
    }
}


