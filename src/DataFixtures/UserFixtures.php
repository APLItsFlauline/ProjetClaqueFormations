<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use App\Entity\User;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $hasher;

    public function __construct(UserPasswordEncoderInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function retireAccents($name)
    {
        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        //Préférez str_replace à strtr car strtr travaille directement sur les octets, ce qui pose problème en UTF-8
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');

        $name = str_replace($search, $replace, $name);
        return $name; //On retourne le résultat
    }
    public function convertSpace($name)
    {
        $search = array(' ','-');
        $replace = array('_','_');

        $name = str_replace($search, $replace, $name);
        return $name;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 50; $i++) {

            $firstName=$faker->firstName;
            $lastName=$faker->lastName;
            $year=$faker->year();

            if ($year<=2022) {
                $mail = 'marseille';
            }
            else {
                $mail = 'mediterranee';
            }

            $user = new User();
            $password = $this->hasher->encodePassword($user, $faker->password);
            echo $firstName.$lastName;
            $user->setUsername((strtolower($this->convertSpace($this->retireAccents($firstName[0].$lastName)))));
            $user->setEmail(strtolower($this->convertSpace($this->retireAccents($firstName.'.'.$lastName.'@centrale-'.$mail.'.fr')))); // Je fais en prévision de Centrale Mediterranee
            $user->setPassword($password);
            $user->setPromo($year);
            $user->setRoles(['ROLE_USER']);
            $user->setIsTeacher($faker->boolean());

            $manager->persist($user);
        }

        $manager->flush();
    }
}
