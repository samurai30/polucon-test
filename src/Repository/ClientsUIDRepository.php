<?php

namespace App\Repository;

use App\Entity\ClientsUID;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClientsUID|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientsUID|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientsUID[]    findAll()
 * @method ClientsUID[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientsUIDRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ClientsUID::class);
    }

    // /**
    //  * @return ClientsUID[] Returns an array of ClientsUID objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClientsUID
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
