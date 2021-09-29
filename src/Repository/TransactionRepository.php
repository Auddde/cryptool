<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * Calcule le solde soit le total tous les prix originaux de toutes les transactions pour un user
     */
    public function soldeUser($idUser)
    {
        return $this->createQueryBuilder('t')
            ->select('sum(t.originalprice)')
            ->setParameter('user_id', $idUser)
            ->where('t.user = :user_id')
            ->getQuery()
            ->getSingleScalarResult()
        ;

    }


}
