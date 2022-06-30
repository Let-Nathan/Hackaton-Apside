<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Technology;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const USER = [

        "user1" => [
            "Matthieu",
            "Denoyer",
            "bob@gmail.com",
            "azerty",
            "ceci est une bio à modifier",
            "Bordeaux",
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3OFHzDozs8IOtg7LyK5o-jSjsRU64AcBFHQ&usqp=CAU"
        ],
        "user2" => [
            "Tonny",
            "Vacca",
            "vacca.tonny@gmail.com",
            "azerty",
            "ceci est une bio à modifier",
            "Bordeaux",
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3OFHzDozs8IOtg7LyK5o-jSjsRU64AcBFHQ&usqp=CAU"
        ],
        "user3" => [
            "Morgan",
            "Freeman",
            "morgan@gmail.com",
            "azerty",
            "ceci est une bio à modifier",
            "Bordeaux",
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3OFHzDozs8IOtg7LyK5o-jSjsRU64AcBFHQ&usqp=CAU"
        ],
        "user4" => [
            "Elon",
            "Musk",
            "stagiaire.elon@gmail.com",
            "azerty",
            "ceci est une bio à modifier",
            "Rome",
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3OFHzDozs8IOtg7LyK5o-jSjsRU64AcBFHQ&usqp=CAU"
        ],
        "user5" => [
            "Giuessepe",
            "PetraroelleI",
            "kingoftheking@gmail.com",
            "azerty",
            "ceci est une bio à modifier",
            "Rome",
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3OFHzDozs8IOtg7LyK5o-jSjsRU64AcBFHQ&usqp=CAU"
        ],
        "user6" => [
            "Estelle",
            "Hitt",
            "estelle@gmail.com",
            "azerty",
            "ceci est une bio à modifier",
            "Rome",
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtD7Z16cPEInHpkV5kQoQxHw0pHD39YK8aZg&usqp=CAU"
        ],

    ];
    private const TECHNO = [
        'JavaScript',
        'Php',
        'Ruby',
        'Python',
        'C#',
        'NodeJs',
        'React',
        'Angular'
    ];
    private const COMPAGNY = ['Paris', 'Bordeaux'];
     private const AVATAR = [
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3OFHzDozs8IOtg7LyK5o-jSjsRU64AcBFHQ&usqp=CAU',
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtD7Z16cPEInHpkV5kQoQxHw0pHD39YK8aZg&usqp=CAU',
    ];



    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // On rajoute des technos
        foreach(self::TECHNO as $value) {
            $technology = new Technology();
            $technology->setName($value);
            $this->addReference($value, $technology);
            $manager->persist($technology);

        }
        // On rajoute des User
//        foreach (self::USER as $key => $value) {
//            $user = new User();
//            $user->setFirstName($value[0]);
//            $user->setLastName($value[1]);
//            $user->setEmail($value[2]);
//            $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
//            $user->setBio($value[4]);
//            $user->setAgency($value[5]);
//            $user->setImageUrl(self::AVATAR[array_rand(self::AVATAR)]);
//            for ($i=0; $i< rand(2, 4); $i++){
//                $user->addTechnology($this->getReference(self::TECHNO[array_rand(self::TECHNO)]));
//            }
//            $manager->persist($user);
//        }

        for($i = 0; $i < 10; $i++) {

            $user = new User();

            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
            $user->setBio($faker->sentence(10));
            $user->setAgency(self::COMPAGNY[array_rand(self::COMPAGNY)]);
            $user->setImageUrl(self::AVATAR[array_rand(self::AVATAR)]);
            for ($i=0; $i < rand(2, 4); $i++){
                $user->addTechnology($this->getReference(self::TECHNO[array_rand(self::TECHNO)]));
            }
            $manager->persist($user);

        }

        $manager->flush();
    }
}
