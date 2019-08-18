<?php

namespace App\Repository;

use App\Entity\InvoicePdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InvoicePdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvoicePdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvoicePdf[]    findAll()
 * @method InvoicePdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoicePdfRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InvoicePdf::class);
    }

    // /**
    //  * @return InvoicePdf[] Returns an array of InvoicePdf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InvoicePdf
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
