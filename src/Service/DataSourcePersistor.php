<?php

namespace App\Service;

use App\Entity\DataSource;
use App\Entity\Experimentation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Service\DataSourcePersistorException;

class DataSourcePersistor
{
	private $dataSource;

	public function __construct(
		private EntityManagerInterface $manager,
		private Security $security
	)
	{
	}

	public function persistDataSource($filename, $csvData)
	{	
		$i = 0;	
		$batchSize = 20;
		
		try {

			$dataSource = new DataSource;

			$dataSource->setFilename($filename);
			$dataSource->setCreatedAt(new \DateTimeImmutable("now"));
			$dataSource->setUploader($this->security->getUser());

			$this->manager->persist($dataSource);
			$this->manager->flush();

			$res = $this->persistExperimentations($csvData, $dataSource->getId());

			$this->dataSource = $dataSource;

			// $count = $this->countExperimentationBySource($dataSource->getId());


		} catch (Exception $e) {
			throw new DataSourcePersistorException(sprintf('Error while persisting data source : %s',$e->getMessage));
		}

		return true;
	}		

	public function getDataSource()
	{
		return $this->dataSource;
	}

	public function persistExperimentations(array $csvData, $sourceId): bool
	{	
		$conn = $this->manager->getConnection();

		$batches = array_chunk($csvData, 1000);

		foreach($batches as $batch)
		{
			$conn->beginTransaction();
			try{
			    
			    foreach($batch as $row)
			    {
			    	$normalized = $this->normalize($row);
			    	$normalized['source_id'] = $sourceId;
					$conn->insert('experimentation', $normalized);
				}

			    $conn->commit();
			} catch (\Exception $e) {
			    $conn->rollBack();
			    throw $e;
			}
		}

		return true;
	}

	// private function createEntity(array $row)
	// {
	// 	$normalized = $this->normalize($row);

	// 	$exp = new Experimentation;

	// 	$exp->setNumExp($normalized['numero-experimentation']);
	// 	$exp->setTypeExp($normalized['type-experimentation']);
	// 	$exp->setSiteEssai($normalized['site-essai']);
	// 	$exp->setSystEssai($normalized['systeme-essai']);
	// 	$exp->setLotCell($normalized['lot-cellules']);
	// 	$exp->setPassage($normalized['passage']);
	// 	$exp->setStress($normalized['stress']);
	// 	$exp->setTempsTraitement($normalized['temps-traitement']);
	// 	$exp->setGene($normalized['genes-analyses']);
	// 	$exp->setProtCorr($normalized['proteine-correspondante']);
	// 	$exp->setProtAnalyse($normalized['proteines-analysees']); 
	// 	$exp->setGeneCorr($normalized['gene-correspondant']);
	// 	$exp->setProjet($normalized['projet']);
	// 	$exp->setNomItem($normalized['nom-item']);
	// 	$exp->setNumItem($normalized['numero-item']);
	// 	$exp->setTypeEchantillon($normalized['type-echantillon']);
	// 	$exp->setNomComm($normalized['nom-commercial']);
	// 	$exp->setRefProduit($normalized['numero-item']);
	// 	$exp->setPourcentageProduit($normalized['pourcentage-produit']);
	// 	$exp->setGenre($normalized['genre']);
	// 	$exp->setEspece($normalized['espece']);
	// 	$exp->setFoldChange($normalized['reference-produit']);
	// 	$exp->setAugmDim($normalized['pourcentage-produit']);
	// 	$exp->setNotation($normalized['genre']);
	// 	$exp->setNomRecDev($normalized['nom-r-et-d']);
	// 	// $exp->setSource($this->dataSource);
		
	// 	return $exp;
	// }

	private function normalize(array $row)
	{
		$arr = [];

		// $arr['numero-experimentation'] 	= trim($row['numero-experimentation']);
		// $arr['type-experimentation'] 	= trim($row['type-experimentation']);
		// $arr['site-essai'] 				= trim($row['site-essai']);
		// $arr['systeme-essai'] 			= trim($row['systeme-essai']);
		// $arr['lot-cellules'] 			= trim($row['lot-cellules']);
		// $arr['passage'] 				= trim($row['passage']);
		// $arr['stress'] 					= trim($row['stress']);
		// $arr['temps-traitement'] 		= trim($row['temps-traitement']);
		// $arr['genes-analyses'] 			= trim($row['genes-analyses']);
		// $arr['proteine-correspondante'] = trim($row['proteine-correspondante']);
		// $arr['proteines-analysees'] 	= trim($row['proteines-analysees']);
		// $arr['gene-correspondant'] 		= trim($row['gene-correspondant']);
		// $arr['projet'] 					= trim($row['projet']);
		// $arr['nom-item'] 				= trim($row['nom-item']);
		// $arr['numero-item'] 			= trim($row['numero-item']);
		// $arr['type-echantillon'] 		= trim($row['type-echantillon']);
		// $arr['nom-r-et-d'] 				= trim($row['nom-r-et-d']);
		// $arr['nom-commercial']	 		= trim($row['nom-commercial']);
		// $arr['reference-produit'] 		= trim($row['reference-produit']);
		// $arr['pourcentage-produit'] 	= trim($row['pourcentage-produit']);
		// $arr['genre'] 					= trim($row['genre']);
		// $arr['fold-change'] 			= trim($row['fold-change']);
		// $arr['augmentation-diminution'] = trim($row['augmentation-diminution']);
		// $arr['notation'] 				= trim($row['notation']);
		// $arr['espece'] 					= trim($row['espece']);


		$arr['num_exp'] 	= trim($row['numero-experimentation']);
		$arr['type_exp'] 	= trim($row['type-experimentation']);
		$arr['site_essai'] 				= trim($row['site-essai']);
		$arr['syst_essai'] 			= trim($row['systeme-essai']);
		$arr['lot_cell'] 			= trim($row['lot-cellules']);
		$arr['passage'] 				= trim($row['passage']);
		$arr['stress'] 					= trim($row['stress']);
		$arr['temps_traitement'] 		= trim($row['temps-traitement']);
		$arr['gene'] 			= trim($row['genes-analyses']);
		$arr['prot_corr'] = trim($row['proteine-correspondante']);
		$arr['prot_analyse'] 	= trim($row['proteines-analysees']);
		$arr['gene_corr'] 		= trim($row['gene-correspondant']);
		$arr['projet'] 					= trim($row['projet']);
		$arr['nom_item'] 				= trim($row['nom-item']);
		$arr['num_item'] 			= trim($row['numero-item']);
		$arr['type_echantillon'] 		= trim($row['type-echantillon']);
		$arr['nom_rec_dev'] 				= trim($row['nom-r-et-d']);
		$arr['nom_comm']	 		= trim($row['nom-commercial']);
		$arr['ref_produit'] 		= trim($row['reference-produit']);
		$arr['pourcentage_produit'] 	= trim($row['pourcentage-produit']);
		$arr['genre'] 					= trim($row['genre']);
		$arr['fold_change'] 			= trim($row['fold-change']);
		$arr['augm_dim'] 				= trim($row['augmentation-diminution']);
		$arr['notation'] 				= trim($row['notation']);
		$arr['espece'] 					= trim($row['espece']);


		return $arr;
	}


	// private function countExperimentationBySource($sourceId)
	// {
	// 	$conn = $this->manager->getConnection();
	// 	$stmt = $conn->prepare('select count(*) from experimentation where source_id = :source_id');
	// 	$stmt->bindValue('source_id', $sourceId);
	// 	$result = $stmt->executeQuery();
	// 	return $result->fetchOne();	
	// }

}