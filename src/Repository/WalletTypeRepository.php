<?php

namespace App\Repository;

use App\Entity\WalletType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WalletType|null find($id, $lockMode = null, $lockVersion = null)
 * @method WalletType|null findOneBy(array $criteria, array $orderBy = null)
 * @method WalletType[]    findAll()
 * @method WalletType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WalletType::class);
    }

    // /**
    //  * @return WalletType[] Returns an array of WalletType objects
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
    public function findOneBySomeField($value): ?WalletType
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
