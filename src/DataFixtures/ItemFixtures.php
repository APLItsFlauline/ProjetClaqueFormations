<?php

namespace App\DataFixtures;

use App\DataFixtures\CourseFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Item;

class ItemFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getReferenceKeyItem($i): string
    {
        return sprintf("ReferenceItem %", $i);
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i=1; $i<=10; $i++){

            $course = $this->getReference(CourseFixtures :: getReferenceKeyCourse($i));

            $item = new Item();
            $item->setName($faker->sentence());
            $item->setChapter($faker->sentence());
            $item->setCourse($course);
            $item->setCreatedOn($faker->dateTimeThisYear());
            $item->setDescription($faker->text());
            $item->setOrdre($faker->numberBetween(0,20));
            $item->setDifficulty($faker->randomDigit);
            $item->setValidationType($faker->randomDigit);

            $manager->persist($item);

            $this->setReference(self::getReferenceKeyItem($i), $item);
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
