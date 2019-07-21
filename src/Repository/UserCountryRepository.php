<?php

namespace App\Repository;

use App\Entity\UserCountry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserCountry|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCountry|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCountry[]    findAll()
 * @method UserCountry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCountryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserCountry::class);
    }

    // /**
    //  * @return UserCountry[] Returns an array of UserCountry objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserCountry
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
