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

    public function findBySource($sourceId) {

        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * from experimentation where source_id = :source_id';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('source_id', $sourceId);

        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();        
    }

    public function getEspeceList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct espece from experimentation order by espece ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getEspeceListAsChoiceList()
    {   
        $arr = [];
        $results = $this->getEspeceList();

        foreach($results as $result)
        {
            $arr[$result['espece']] = $result['espece'];
        }

        return $arr;
    }

    public function geneLookup(string $pattern, int $limit = 10)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT distinct gene from experimentation where gene ilike :pattern order by gene ASC limit :limit";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('pattern', $pattern . '%');
        $stmt->bindValue('limit', $limit);

        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getGenreList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct genre from experimentation order by genre ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getGenreListAsChoiceList()
    {   
        $arr = [];
        $results = $this->getGenreList();

        foreach($results as $result)
        {
            $arr[$result['genre']] = $result['genre'];
        }

        return $arr;
    }

    public function getLotCellList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct lot_cell from experimentation order by lot_cell ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getLotCellListAsChoiceList()
    {
        $arr = [];
        $results = $this->getLotCellList();

        foreach($results as $result)
        {
            $arr[$result['lot_cell']] = $result['lot_cell'];
        }

        return $arr;
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

    public function getNotationList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct notation from experimentation order by notation ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getNotationListAsChoiceList()
    {   
        $arr = [];
        $results = $this->getNotationList();

        foreach($results as $result)
        {
            $arr[$result['notation']] = $result['notation'];
        }

        return $arr;
    }

    public function getNumExpList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct num_exp from experimentation order by num_exp ASC';
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

    public function getNumItemList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct num_item from experimentation order by num_item ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getNumItemListAsChoiceList()
    {
        $arr = [];
        $results = $this->getNumItemList();

        foreach($results as $result)
        {
            $arr[$result['num_item']] = $result['num_item'];
        }

        return $arr;
    }

    public function getPassageList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct passage from experimentation order by passage ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getPassageListAsChoiceList()
    {
        $arr = [];
        $results = $this->getPassageList();

        foreach($results as $result)
        {
            $arr[$result['passage']] = $result['passage'];
        }

        return $arr;
    }

    public function getProjectList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct projet from experimentation order by projet ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getProjectListAsChoiceList()
    {
        $arr = [];
        $results = $this->getProjectList();

        foreach($results as $result)
        {
            $arr[$result['projet']] = $result['projet'];
        }

        return $arr;
    }

    public function getProtCorrList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct prot_corr from experimentation order by prot_corr ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getProtCorrListAsChoiceList()
    {   
        $arr = [];
        $results = $this->getProtCorrList();

        foreach($results as $result)
        {
            $arr[$result['prot_corr']] = $result['prot_corr'];
        }

        return $arr;
    }

    public function getTypeEchantillonList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct type_echantillon from experimentation order by type_echantillon ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getTypeEchantillonListAsChoiceList()
    {   
        $arr = [];
        $results = $this->getTypeEchantillonList();

        foreach($results as $result)
        {
            $arr[$result['type_echantillon']] = $result['type_echantillon'];
        }

        return $arr;
    }

    public function getTypeExpList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct type_exp from experimentation order by type_exp ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
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

    public function getSiteEssaiList()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT distinct site_essai from experimentation order by site_essai ASC';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getSiteEssaiListAsChoiceList()
    {   
        $arr = [];
        $results = $this->getSiteEssaiList();

        foreach($results as $result)
        {
            $arr[$result['site_essai']] = $result['site_essai'];
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

        if(!empty($dto->syst_essai))
        {
            $qb
                ->andWhere('e.syst_essai = :syst_essai')
                ->setParameter('syst_essai', $dto->syst_essai)
            ;
        }

        if(!empty($dto->projet))
        {
            $qb
                ->andWhere('e.projet = :projet')
                ->setParameter('projet', $dto->projet)
            ;
        }
        
        if(!empty($dto->num_item))
        {
            $qb
                ->andWhere('e.num_item = :num_item')
                ->setParameter('num_item', $dto->num_item)
            ;
        }
        
        if(!empty($dto->genre))
        {
            $qb
                ->andWhere('e.genre = :genre')
                ->setParameter('genre', $dto->genre)
            ;
        }

        if(!empty($dto->espece))
        {
            $qb
                ->andWhere('e.espece = :espece')
                ->setParameter('espece', $dto->espece)
            ;
        }

        if(!empty($dto->lot_cell))
        {
            $qb
                ->andWhere('e.lot_cell = :lot_cell')
                ->setParameter('lot_cell', $dto->lot_cell)
            ;
        }

        if(!empty($dto->passage))
        {
            $qb
                ->andWhere('e.passage = :passage')
                ->setParameter('passage', $dto->passage)
            ;
        }

        if(!empty($dto->notation))
        {
            $qb
                ->andWhere('e.notation = :notation')
                ->setParameter('notation', $dto->notation)
            ;
        }

        if(!empty($dto->type_echantillon))
        {
            $qb
                ->andWhere('e.type_echantillon = :type_echantillon')
                ->setParameter('type_echantillon', $dto->type_echantillon)
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
