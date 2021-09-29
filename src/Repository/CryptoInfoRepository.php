<?php

namespace App\Repository;

use App\Entity\CryptoInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CryptoInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CryptoInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CryptoInfo[]    findAll()
 * @method CryptoInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CryptoInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CryptoInfo::class);
    }

    // /**
    //  * @return CryptoInfo[] Returns an array of CryptoInfo objects
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
    public function findOneBySomeField($value): ?CryptoInfo
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
