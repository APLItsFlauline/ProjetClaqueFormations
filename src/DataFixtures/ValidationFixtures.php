<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use App\DataFixtures\ItemFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Validation;
use App\Entity\Item;
use App\Entity\User;

class ValidationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $repoUser=$manager->getRepository(User::class);
        $users=$repo->findAll();

        $repoItem=$manager->getRepository(Item::class);
        $items=$repo->findAll();

        $nb=max(count($items),count($users));


        for($i=1; $i<=$nb;$i++){

            $validation = new Validation();
            $validation->setAuthor($users[$i]);
            $validation->setItem($items[$i]);
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
