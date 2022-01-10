<?php

namespace App\DataFixtures;

use App\DataFixtures\CourseFixtures;
use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Item;



class ItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $repo=$manager->getRepository(Course::class);
        $courses=$repo->findAll();
        $nbCourses=count($courses);

        for($i=1; $i<$nbCourses; $i++){

            $item = new Item();
            $item->setName($faker->sentence());
            $item->setChapter($faker->sentence());
            $item->setCourse($courses[$i]);
            $item->setCreatedOn($faker->dateTimeThisYear());
            $item->setDescription($faker->text());
            $item->setIOrder($faker->randomDigit);
            $item->setDifficulty($faker->randomDigit);
            $item->setValidationType($faker->randomDigit);

            $manager->persist($item);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CourseFixtures::class
        ];
    }
}
