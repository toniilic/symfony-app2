<?php

namespace App\Repository;

use App\Entity\Bonus;
use App\Entity\Casino;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bonus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bonus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bonus[]    findAll()
 * @method Bonus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BonusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bonus::class);
    }

    // /**
    //  * @return Bonus[] Returns an array of Bonus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bonus
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getBonusesByUserOnTodaysDate(User $user)
    {
        $qb = $this->createQueryBuilder('b')
            ->where('b.publishedAt < :today')
            ->andWhere('b.publishedAt > :yesterday')
            ->andWhere('b.author = :user')
            ->setParameter('user', $user)
            ->setParameter('today', new \DateTime())
            ->setParameter('yesterday', new \DateTime('-1 day'))
            ->orderBy('b.publishedAt', 'DESC')
            ->getQuery();

        return $qb->execute();
    }


    public function getBonusesByCasinoOnTodaysDate(Casino $casino)
    {
        $qb = $this->createQueryBuilder('b')
            ->where('b.publishedAt < :today')
            ->andWhere('b.publishedAt > :yesterday')
            ->andWhere('b.casino = :casino')
            ->setParameter('casino', $casino)
            ->setParameter('today', new \DateTime())
            ->setParameter('yesterday', new \DateTime('-1 day'))
            ->orderBy('b.publishedAt', 'DESC')
            ->getQuery();

        return $qb->execute();
    }
}
