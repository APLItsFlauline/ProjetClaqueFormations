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
        for($i=1; $i<=10;$i++){

            $user = $this->getReference(UserFixtures::getReferenceKeyUser($i));
            $item = $this->getReference(ItemFixtures::getReferenceKeyItem($i));

            $validation = new Validation();
            $validation->setAuthor($user);
            $validation->setItem($item);
            $validation->setFeedback("Le GP est insane, surtout la séance n°".$i);
            $validation->setPayload("CODE");
            $validation->setValid(0);
            $validation->setValidatedOn(new \DateTime());

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
