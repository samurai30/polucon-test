<?php

namespace App\Repository;

use App\Entity\FormTasks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FormTasks|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormTasks|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormTasks[]    findAll()
 * @method FormTasks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormTasksRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FormTasks::class);
    }

    // /**
    //  * @return FormTasks[] Returns an array of FormTasks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormTasks
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
