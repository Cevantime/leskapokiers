<?php

namespace App\Repository;

use App\Entity\Artist;
use App\Entity\Tag;
use App\Service\Slugger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Artist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artist[]    findAll()
 * @method Artist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    public function getCorrespondingArtist($pseudonym)
    {
        $artist = $this->findOneBy(['pseudonym'=>$pseudonym]);
        if(! $artist){
            $artist = new Artist();
            $artist->setPseudonym($pseudonym);
        }
        return $artist;
    }

    public function findByPseudonym($pseudonym)
    {
        return $this->createQueryBuilder('a')
            ->where('LOWER(a.pseudonym) LIKE :pseudonym')
            ->setParameter('pseudonym', strtolower($pseudonym))
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Artist[] Returns an array of Artist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Artist
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
