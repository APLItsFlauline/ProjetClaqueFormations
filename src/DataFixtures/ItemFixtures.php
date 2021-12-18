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
        for($i=1; $i<=10; $i++){

            $course = $this->getReference(CourseFixtures :: getReferenceKeyCourse($i));

            $item = new Item();
            $item->setName("Item n°".$i);
            $item->setChapter("Chapitre n°".$i);
            $item->setCourse($course);
            $item->setCreatedOn(new \DateTime());
            $item->setDescription("L'item ".$i." est incroyable");
            $item->setOrdre("$i");
            $item->setDifficulty(3);
            $item->setValidationType(1);

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
