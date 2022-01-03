<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use App\DataFixtures\ItemFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Validation;

class ValidationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i=1; $i<=10;$i++){

            $user = $this->getReference(UserFixtures::getReferenceKeyUser($i));
            $item = $this->getReference(ItemFixtures::getReferenceKeyItem($i));

            $validation = new Validation();
            $validation->setAuthor($user);
            $validation->setItem($item);
            $validation->setFeedback($faker->paragraphs());
            $validation->setPayload($faker->text());
            $validation->setValid($faker->boolean());
            $validation->setValidatedOn($faker->dateTimeThisYear());

            $manager->persist($validation);

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ItemFixtures::class
        ];
    }
}
