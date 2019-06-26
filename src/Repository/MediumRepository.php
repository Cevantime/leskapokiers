<?php

namespace App\Repository;

use App\Entity\Medium;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Medium|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medium|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medium[]    findAll()
 * @method Medium[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediumRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Medium::class);
    }
    


//    /**
//     * @return Mediul[] Returns an array of Medium objects
//     */
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
    public function findOneBySomeField($value): ?Medium
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
