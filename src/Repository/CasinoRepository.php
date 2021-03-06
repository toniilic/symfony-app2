<?php

namespace App\Repository;

use App\Entity\Casino;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Casino|null find($id, $lockMode = null, $lockVersion = null)
 * @method Casino|null findOneBy(array $criteria, array $orderBy = null)
 * @method Casino[]    findAll()
 * @method Casino[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CasinoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Casino::class);
    }

    // /**
    //  * @return Casino[] Returns an array of Casino objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Casino
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

/*    public function getCasinoSubmissionsForToday(Casino $casino)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.id < :id')
            ->andWhere('c.publishedAt < :today')
            ->andWhere('c.publishedAt > :yesterday')
            ->setParameter('id', $casino->getId())
            ->setParameter('today', new \DateTime())
            ->setParameter('yesterday', new \DateTime('-1 day'))
            ->orderBy('c.publishedAt', 'DESC')
            ->getQuery();

        return $qb->execute();
    }*/
}
