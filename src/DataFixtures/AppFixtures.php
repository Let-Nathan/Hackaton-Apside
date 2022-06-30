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
            "Giuseppe",
            "Petraroli",
            "g.petraroli@gmail.com",
            "azerty",
            "I’m an enthusiastic web developer student of the Wild Code School in Bordeaux, France.
I’ve always been extremely passionate about web development and computer science which is why I’ve decided to became a web developer.

I believe in continuous growth and improvement, both in personal and professional life. This approach has always encouraged me to be proactive and work on innovative projects with teams of different people, always bringing enthusiasm and positive energy.

In my free time I am also a very good amateur photographer, dog trainer and of course an excellent cook😉.",
            "Rome",
            "https://media-exp1.licdn.com/dms/image/C5603AQH0gA5Dvu7O2g/profile-displayphoto-shrink_800_800/0/1650395403426?e=1661990400&v=beta&t=NCfkimd_t31Y5foySzqxp6SaV-6QC5JQydEmN1L5W54"
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
//         On rajoute des User

//            $user = new User();
//            $user->setFirstName(self::USER[4][0]);
//            $user->setLastName(self::USER[4][1]);
//            $user->setEmail(self::USER[4][2]);
//            $user->setPassword($this->hasher->hashPassword($user, 'qwerty'));
//            $user->setBio(self::USER[4][4]);
//            $user->setAgency(self::USER[4][5]);
//            $user->setImageUrl(self::AVATAR[array_rand(self::AVATAR)]);
//
//            $user->addTechnology($this->getReference(self::TECHNO[0]));
//            $user->addTechnology($this->getReference(self::TECHNO[1]));
//
//            $manager->persist($user);



        for($i = 0; $i < 10; $i++) {

            $user = new User();

            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
            $user->setBio($faker->sentence(10));
            $user->setAgency(self::COMPAGNY[array_rand(self::COMPAGNY)]);
            $user->setImageUrl(self::AVATAR[array_rand(self::AVATAR)]);


            $user->addTechnology($this->getReference(self::TECHNO[0]));
            $user->addTechnology($this->getReference(self::TECHNO[1]));
            $manager->persist($user);
        }

        for($i = 0; $i < 20; $i++) {

            $user = new User();

            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
            $user->setBio($faker->sentence(10));
            $user->setAgency(self::COMPAGNY[array_rand(self::COMPAGNY)]);
            $user->setImageUrl(self::AVATAR[array_rand(self::AVATAR)]);

            $user->addTechnology($this->getReference(self::TECHNO[1]));
            $user->addTechnology($this->getReference(self::TECHNO[2]));
            $user->addTechnology($this->getReference(self::TECHNO[3]));
            $manager->persist($user);
        }

        for($i = 0; $i < 20; $i++) {

            $user = new User();

            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
            $user->setBio($faker->sentence(10));
            $user->setAgency(self::COMPAGNY[array_rand(self::COMPAGNY)]);
            $user->setImageUrl('giuseppe.png');

            $user->addTechnology($this->getReference(self::TECHNO[2]));
            $user->addTechnology($this->getReference(self::TECHNO[4]));
            $manager->persist($user);
        }

        for($i = 0; $i < 20; $i++) {

            $user = new User();

            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
            $user->setBio($faker->sentence(10));
            $user->setAgency(self::COMPAGNY[array_rand(self::COMPAGNY)]);
            $user->setImageUrl(self::AVATAR[array_rand(self::AVATAR)]);

            $user->addTechnology($this->getReference(self::TECHNO[6]));
            $user->addTechnology($this->getReference(self::TECHNO[7]));
            $manager->persist($user);
        }
        $manager->flush();

    }
}
