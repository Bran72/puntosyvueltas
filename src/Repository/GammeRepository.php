<?php

namespace App\Repository;

use App\Entity\Gamme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Gamme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gamme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gamme[]    findAll()
 * @method Gamme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GammeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Gamme::class);
    }

    // /**
    //  * @return Gamme[] Returns an array of Gamme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Gamme
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
