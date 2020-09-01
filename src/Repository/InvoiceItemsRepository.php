<?php

namespace App\Repository;

use App\Entity\InvoiceItems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InvoiceItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvoiceItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvoiceItems[]    findAll()
 * @method InvoiceItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceItemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvoiceItems::class);
    }

    // /**
    //  * @return InvoiceItems[] Returns an array of InvoiceItems objects
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
    public function findOneBySomeField($value): ?InvoiceItems
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
