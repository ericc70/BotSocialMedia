<?php

namespace App\Repository;

use App\Entity\BotContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BotContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method BotContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method BotContent[]    findAll()
 * @method BotContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BotContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BotContent::class);
    }

    // /**
    //  * @return BotContent[] Returns an array of BotContent objects
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
    public function findOneBySomeField($value): ?BotContent
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
