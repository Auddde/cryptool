<?php

namespace App\Repository;

use App\Entity\Valorisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Valorisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Valorisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Valorisation[]    findAll()
 * @method Valorisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValorisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Valorisation::class);
    }

    // /**
    //  * @return Valorisation[] Returns an array of Valorisation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Valorisation
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
