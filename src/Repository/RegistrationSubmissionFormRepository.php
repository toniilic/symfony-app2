<?php

namespace App\Repository;

use App\Entity\RegistrationSubmissionForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RegistrationSubmissionForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegistrationSubmissionForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegistrationSubmissionForm[]    findAll()
 * @method RegistrationSubmissionForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistrationSubmissionFormRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RegistrationSubmissionForm::class);
    }

    // /**
    //  * @return RegistrationSubmissionForm[] Returns an array of RegistrationSubmissionForm objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RegistrationSubmissionForm
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
