<?php

namespace App\Service;

use App\Entity\DataSource;
use App\Entity\Experimentation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Service\DataSourcePersistorException;

class DataSourcePersistor
{
	private $datasource;

	public function __construct(
		private EntityManagerInterface $manager,
		private Security $security
	)
	{
	}

	public function persistDataSource($filename): bool
	{
		try {

			$dataSource = new DataSource;

			$dataSource->setFilename($filename);
			$dataSource->setCreatedAt(new \DateTimeImmutable("now"));
			$dataSource->setUploader($this->security->getUser());

			$this->manager->persist($dataSource);
			$this->manager->flush();

			$this->dataSource = $dataSource;

		} catch (Exception $e) {
			throw new DataSourcePersistorException('Error while persisting data source');	
		}

		return true;
	}	

	public function persistExperimentations(array $csvData): bool
	{
		return true;
	}

	public function getDatasource(): DataSource
	{
		return $this->dataSource;
	}
}