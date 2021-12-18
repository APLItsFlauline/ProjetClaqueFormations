<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public static function getReferenceKeyUser($i): string
    {
        return sprintf("ReferenceUser %f", $i);
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {

            $user = new User();
            $user->setUsername("Utilisateur n°".$i);
            $user->setEmail("utilisateur".$i."@centrale-marseille.fr");
            $user->setPassword("admin123".$i);
            $user->setFirstName("Prenom n°".$i);
            $user->setLastName("Nom n°".$i);
            $user->setPromo(2016);
            $user->setRoles([]);
            $user->setIsTeacher(true);

            $manager->persist($user);

            $this->setReference(self::getReferenceKeyUser($i), $user);

        }

        $manager->flush();
    }
}
