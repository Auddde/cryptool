<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method Wallet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wallet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wallet[]    findAll()
 * @method Wallet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    /**
     * Génère le porteuille en fonction de son $id + de l'$id de l'utilisateur
     * Empêche les utilisateurs connectés d'accéder à des portefeuilles ne leur appartenant pas.
     */
    public function generateWallet(Uuid $uuidWallet, User $user) {
        return $this->createQueryBuilder('w')
            ->select('w')
            ->setParameter('user_id', $user->getId())
            ->setParameter('wallet_uuid', $uuidWallet, 'uuid')
            ->where('w.user = :user_id')
            ->andWhere('w.uuid = :wallet_uuid')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
