<?php

namespace App\Repository;

use App\Entity\WalletCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WalletCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method WalletCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method WalletCategory[]    findAll()
 * @method WalletCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WalletCategory::class);
    }

    // /**
    //  * @return WalletCategory[] Returns an array of WalletCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WalletCategory
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
