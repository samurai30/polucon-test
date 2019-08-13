<?php

namespace App\Repository;

use App\Entity\SurveyorUID;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SurveyorUID|null find($id, $lockMode = null, $lockVersion = null)
 * @method SurveyorUID|null findOneBy(array $criteria, array $orderBy = null)
 * @method SurveyorUID[]    findAll()
 * @method SurveyorUID[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurveyorUIDRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SurveyorUID::class);
    }

    // /**
    //  * @return SurveyorUID[] Returns an array of SurveyorUID objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SurveyorUID
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
