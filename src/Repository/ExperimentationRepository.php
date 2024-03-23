<?php

namespace App\Repository;

use App\Dto\ExpFinderDto;
use App\Entity\Experimentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Experimentation>
 *
 * @method Experimentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Experimentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Experimentation[]    findAll()
 * @method Experimentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExperimentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Experimentation::class);
    }

    public function countBySource(int $sourceId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT count(*) from experimentation where source_id = :source_id';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('source_id', $sourceId);
        $result = $stmt->executeQuery();       

        return $result->fetchOne(); 
    }

    public function getNumExpList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct num_exp from experimentation order by num_exp ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getTypeExpList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct type_exp from experimentation order by type_exp ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getNumExpListAsChoiceList()
    {   
        $arr = [];
        $results = $this->getNumExpList();

        foreach($results as $result)
        {
            $arr[$result['num_exp']] = $result['num_exp'];
        }

        return $arr;
    }

    public function getTypeExpListAsChoiceList()
    {   
        $arr = [];
        $results = $this->getTypeExpList();

        foreach($results as $result)
        {
            $arr[$result['type_exp']] = $result['type_exp'];
        }

        return $arr;
    }


    public function getNumItemList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct num_item from experimentation order by num_item ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getProjectList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct project from experimentation order by project ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function geneLookup(string $pattern, int $limit = 10)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct gene from experimentation where gene ilike :gene order by gene ASC limit :limit';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('pattern', $pattern . '%');
        $stmt->bindValue('limit', $limit);

        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getNomCommList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct nom_comm from experimentation order by nom_comm ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getNomCommListAsChoiceList()
    {   
        $arr = [];
        $results = $this->getNomCommList();

        foreach($results as $result)
        {
            $arr[$result['nom_comm']] = $result['nom_comm'];
        }

        return $arr;
    }

    public function getSystEssaiList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct syst_essai from experimentation order by syst_essai ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getSystEssaiListAsChoiceList()
    {   
        $arr = [];
        $results = $this->getSystEssaiList();

        foreach($results as $result)
        {
            $arr[$result['syst_essai']] = $result['syst_essai'];
        }

        return $arr;
    }


    public function search(ExpFinderDto $dto)
    {
        $qb = $this->createQueryBuilder('e');

        if(!empty($dto->num_exp))
        {
            $qb
                ->andWhere('e.num_exp = :num_exp')
                ->setParameter('num_exp', $dto->num_exp)
            ;
        }

        if(!empty($dto->type_exp))
        {
            $qb
                ->andWhere('e.type_exp = :type_exp')
                ->setParameter('type_exp', $dto->type_exp)
            ;
        }

        if(!empty($dto->nom_comm))
        {
            $qb
                ->andWhere('e.nom_comm = :nom_comm')
                ->setParameter('nom_comm', $dto->nom_comm)
            ;
        }

        if(!empty($dto->gene))
        {
            $qb
                ->andWhere('e.gene = :gene')
                ->setParameter('gene', $dto->gene)
            ;
        }

       return $qb
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
        ;

    }


//    /**
//     * @return Experimentation[] Returns an array of Experimentation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Experimentation
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
