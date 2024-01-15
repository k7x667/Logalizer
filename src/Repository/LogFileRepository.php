<?php

namespace App\Repository;

use App\Entity\LogFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogFile>
 *
 * @method LogFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogFile[]    findAll()
 * @method LogFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogFile::class);
    }

//    /**
//     * @return LogFile[] Returns an array of LogFile objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LogFile
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
