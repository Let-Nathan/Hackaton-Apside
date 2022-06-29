<?php
//
//namespace App\DataFixtures;
//
//use App\Entity\Project;
//use App\Entity\User;
//use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Persistence\ObjectManager;
//
//class userFixtures extends Fixture
//{
//    private const USER = [
//
//        "user1" => [
//            "Matthieu",
//            "Denoyer",
//            "bob@gmail.com",
//            "azerty",
//            "ceci est une bio à modifier",
//            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3OFHzDozs8IOtg7LyK5o-jSjsRU64AcBFHQ&usqp=CAU"
//        ],
//        "user2" => [
//            "Tonny",
//            "Vacca",
//            "vacca.tonny@gmail.com",
//            "azerty",
//            "ceci est une bio à modifier",
//            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3OFHzDozs8IOtg7LyK5o-jSjsRU64AcBFHQ&usqp=CAU"
//        ],
//        "user3" => [
//            "Morgan",
//            "Freeman",
//            "morgan@gmail.com",
//            "azerty",
//            "ceci est une bio à modifier",
//            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3OFHzDozs8IOtg7LyK5o-jSjsRU64AcBFHQ&usqp=CAU"
//        ],
//        "user4" => [
//            "Elon",
//            "Musk",
//            "stagiaire.elon@gmail.com",
//            "azerty",
//            "ceci est une bio à modifier",
//            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3OFHzDozs8IOtg7LyK5o-jSjsRU64AcBFHQ&usqp=CAU"
//        ],
//        "user5" => [
//            "Giuessepe",
//            "Petraro",
//            "kingoftheking@gmail.com",
//            "azerty",
//            "ceci est une bio à modifier",
//            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3OFHzDozs8IOtg7LyK5o-jSjsRU64AcBFHQ&usqp=CAU"
//        ],
//        "user6" => [
//            "Estelle",
//            "Hitt",
//            "estelle@gmail.com",
//            "azerty",
//            "ceci est une bio à modifier",
//            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtD7Z16cPEInHpkV5kQoQxHw0pHD39YK8aZg&usqp=CAU"
//        ],
//
//    ];
//    private const TECHNO = [
//        'JavaScript',
//        'Php',
//        'Ruby',
//        'Python',
//        'C#',
//        'NodeJs',
//        'React',
//        'Angular'
//    ];
//    private const LINKS = [
//        "Github",
//        "Slack",
//        "Facebook",
//        "Trello"
//    ],
//
//
//    public function load(ObjectManager $manager)
//    {
//        foreach (self::USER as $key => $value) {
//            $user = new User();
//            dd($value[0]);
//        }
//        $manager->flush();
//        $manager->persist($user);
//    }
//}