<?php

namespace App\Repository;

use App\Entity\Evidence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Evidence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evidence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evidence[]    findAll()
 * @method Evidence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvidenceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evidence::class);
    }

}
