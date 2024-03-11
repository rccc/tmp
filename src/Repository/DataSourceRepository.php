<?php

namespace App\Repository;

use App\Entity\DataSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataSource>
 *
 * @method DataSource|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataSource|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataSource[]    findAll()
 * @method DataSource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataSourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataSource::class);
    }

    public function findAllWithExperimentationCount()
    {
        $arr = [];
        $results = $this->createQueryBuilder('s')
            ->leftJoin('s.experimentations', 'e')
            ->leftJoin('s.uploader', 'u')
            ->addSelect('count(e) as countExp')
            ->addSelect('u')
            ->addGroupBy('s.id', 'u.id')
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
       ;

       foreach ($results as $row)
       {
            dump($row);
            $row[0]->setCountExp($row['countExp']);
            $arr[] = $row[0];
       }

       return $arr;
    }

//    /**
//     * @return DataSource[] Returns an array of DataSource objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DataSource
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
