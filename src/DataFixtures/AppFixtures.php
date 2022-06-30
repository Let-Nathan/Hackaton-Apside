<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Technology;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
//    private const LINKS = [
//        "Github",
//        "Slack",
//        "Facebook",
//        "Trello"
//    ];

    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // On rajoute des technos
        foreach(self::TECHNO as $value) {
            $technology = new Technology();
            $technology->setName($value);
            $this->addReference($value, $technology);
            $manager->persist($technology);

        }
        // On rajoute des User
        foreach (self::USER as $key => $value) {
            $user = new User();
            $user->setFirstName($value[0]);
            $user->setLastName($value[1]);
            $user->setEmail($value[2]);
            $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
            $user->setBio($value[4]);
            $user->setAgency($value[5]);
            $user->setImageUrl($value[6]);
            for ($i=0; $i< rand(2, 4); $i++){
                $user->addTechnology($this->getReference(self::TECHNO[array_rand(self::TECHNO)]));
            }
            $manager->persist($user);
        }

        $project = new Project();
        $project->setTitle('Supervision applicative SNCF RÉSEAU');

        $project->setDescription('Au sein de la DSI de SNCF Réseau, la Division COP est notamment responsable de la supervision opérationnelle applicative, de l’exploitation du SI, ainsi que de l’administration des plateformes techniques. La définition et la mise en place d’une supervision spécifique à chaque application (plus de 250, dont 1/3 de critiques) est devenue une mission majeure de la Division COP. Depuis 2013, Apside accompagne ses clients sur les sujets de la supervision applicative et de maintien en conditions opérationnelles des infrastructures.');
        $project->setIsFinished(true);

        $manager->flush();


    }
}
