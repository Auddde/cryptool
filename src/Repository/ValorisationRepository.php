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

    /**
     * Supprimer de la BDD une valorisation
     */
    public function removeValorisation(Valorisation $valorisation)
    {
        $em = $this->getEntityManager();
        $em->remove($valorisation);
        $em->flush();
    }

}
