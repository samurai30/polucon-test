<?php

namespace App\Repository;

use App\Entity\InvoiceImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InvoiceImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvoiceImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvoiceImage[]    findAll()
 * @method InvoiceImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InvoiceImage::class);
    }

    // /**
    //  * @return InvoiceImage[] Returns an array of InvoiceImage objects
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
    public function findOneBySomeField($value): ?InvoiceImage
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
