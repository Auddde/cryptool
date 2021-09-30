<?php

namespace App\Repository;

use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

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
     * Génère la transactions en fonction de son $id + de l'$id de l'utilisateur
     * Empêche les utilisateurs connectés d'accéder à des transactions ne leur appartenant pas.
     */
    public function generateTransaction(Uuid $uuidTransaction, User $user) {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->setParameter('user_id', $user->getId())
            ->setParameter('transaction_uuid', $uuidTransaction,  'uuid')
            ->where('t.user = :user_id')
            ->andWhere('t.uuid = :transaction_uuid')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * Calcule le solde soit le total tous les prix originaux de toutes les transactions pour un user
     */
    public function soldeUser(int $idUser)
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
