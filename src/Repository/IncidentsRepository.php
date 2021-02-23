<?php

namespace App\Repository;

use App\Entity\Tincidents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tincidents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tincidents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tincidents[]    findAll()
 * @method Tincidents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncidentsRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tincidents::class);
    }

    public  function maxid(): ?int
    {
        $qb=$this->createQueryBuilder('q');
        $qb->andWhere('q.id = max(q.id)');
        return $qb->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Tincidents[] Returns an array of Tincidents objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tincidents
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
