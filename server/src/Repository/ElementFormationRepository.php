<?php

namespace App\Repository;

use App\Entity\ElementFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ElementFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElementFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElementFormation[]    findAll()
 * @method ElementFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElementFormationRepository extends ServiceEntityRepository
{
    /**
     * ElementFormationRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElementFormation::class);
    }
}
