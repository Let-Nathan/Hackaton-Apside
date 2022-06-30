<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function add(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSimilar($search)
    {
        $arrWords = explode(' ', $search);
        $result = [];

        $projects = $this->findAll();
        foreach ($projects as $project) {
           $count = 0;

            foreach ($arrWords as $word) {
                if (strlen($word) > 4 && $this->getEntityManager()->getConnection()->fetchAllAssociative("SELECT * FROM project WHERE description LIKE '%" . $word . "%'")) {
                    $count++;
                }
            }
            if ($count >= 3) {
                $result[] = $project;
            }
        }

//        $result = $this->getEntityManager()->getConnection()->fetchAllAssociative("SELECT * FROM project WHERE description REGEXP '(?=.*parola1)(?=.*parola2)(?=.*parola3)'");

        return $result;
//        return $this->createQueryBuilder('u')
//            ->where('u.firstName LIKE :value OR u.lastName LIKE :value OR u.email LIKE :value OR u.agency LIKE :value')
//            ->setParameter('value', '%'. $value .'%')
//            ->orderBy('u.lastName', 'ASC')
//            ->getQuery()
//            ->getResult();
    }

//    /**
//     * @return Project[] Returns an array of Project objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Project
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
