<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Course;


class CourseFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getReferenceKeyCourse($i): string
    {
        return sprintf("ReferenceCourse %", $i);
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 10; $i++){

            $course = new Course();
            $course->setCreatedBy($this->getReference(UserFixtures :: getReferenceKeyUser($i)));
            $course->setActive($faker->boolean());
            $course->setName($faker->sentence());
            $course->setOpen($faker->boolean());
            for($j=1; $j<=$i;$j++){
                $course->addPerson($this->getReference(UserFixtures :: getReferenceKeyUser($j)));
            }

            $manager->persist($course);

            $this->setReference(self::getReferenceKeyCourse($i), $course);
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


