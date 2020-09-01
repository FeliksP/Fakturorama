<?php

namespace App\Repository;

use App\Entity\Invoices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Invoices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoices[]    findAll()
 * @method Invoices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoicesRepository extends ServiceEntityRepository {
private  $paginator;
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator) {
        parent::__construct($registry, Invoices::class);
        
        $this->paginator = $paginator;
    }

    public function getXLatestRecords($offset, $numberOfRowsToReturn) {

        $query = $this->createQueryBuilder('i')
                ->orderBy('i.Number', 'DESC')
                ->setMaxResults($numberOfRowsToReturn)
                ->setFirstResult($offset)
                ->leftJoin('i.Item', 'ii')
                ->addSelect('ii')
                //  ->groupBy('i.id')
                ->getQuery();

        $invoices = $query->getResult();
        //dump($invoices);
        return $invoices;
    }

    public function findAllPaginated($page) {

        $query = $this->createQueryBuilder('i')
        ->leftJoin('i.Item', 'ii')
        ->addSelect('ii')
        ->orderBy('i.Number', 'DESC');
        
        $pagination = $this->paginator->paginate($query, $page, 10);
        return $pagination;
    }

    // /**
    //  * @return Invoices[] Returns an array of Invoices objects
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
      public function findOneBySomeField($value): ?Invoices
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
