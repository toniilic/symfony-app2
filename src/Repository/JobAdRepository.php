<?php

namespace App\Repository;

use App\Entity\JobAd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method JobAd|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobAd|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobAd[]    findAll()
 * @method JobAd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobAdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JobAd::class);
    }

    // /**
    //  * @return JobAd[] Returns an array of JobAd objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JobAd
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
