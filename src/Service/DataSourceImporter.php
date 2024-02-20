<?php

namespace App\Service;

use App\Service\DataSourceUploader;
use App\Service\DataSourceValidator;
use App\Entity\DataSource;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Service\Exception\DataSourceImporterException;
use App\Service\Exception\DataSourceUploaderException;
use App\Service\Exception\DataSourceValidatorException;

class DataSourceImporter
{
	private $filename;
	private $error;

	public function __construct(
	    private DataSourceUploader $uploader,
	    private DataSourceValidator $validator,
	    private EntityManagerInterface $manager,
	    private Security $security
	) {
	}
	
	public function import(UploadedFile $file, DataSource $dataSource)
	{
		try {
	
			$this->filename = $this->upload($file);	

			if(empty($this->filename))
			{	
				$this->uploader->deleteFile();
				throw new DataSourceImporterException('Uploaded file was not found by DataSourceImporter');
			}


		} catch (DataSourceUploaderException $e) {
			$this->uploader->deleteFile();
			$this->error = $e->getMessage();
			return false;
		}

		try {

			$isValid = $this->validator->validate($this->filename);
			
			if(!$isValid)
			{
				$this->error = $this->validator->getError();				
				$this->uploader->deleteFile();
				return false;
			}

		} catch (DataSourceValidatorException $e) {
			$this->uploader->deleteFile();
			$this->error = $e->getMessage();
			return false;	
		}

		try {
			$ret = $this->persistDataSource($dataSource);
			if($ret !== true)
			{
				$this->uploader->deleteFile();
				throw new DataSourceImporterException('DataSourcePersister return false without exception');
			}					
		} catch (Exception $e) {
			$this->uploader->deleteFile();
			$this->error = $e->getMessage();
			return false;	
		}

		return true;
	}

	private function upload(UploadedFile $file)
	{	
		$filename = null;
		$filename = $this->uploader->upload($file);		
		return $filename;
	}

	private function persistDataSource($dataSource)
	{
		try {
			
			$dataSource->setFilename($this->filename);
			$dataSource->setCreatedAt(new \DateTimeImmutable("now"));
			$dataSource->setUploader($this->security->getUser());

			$this->manager->persist($dataSource);
			$this->manager->flush();

		} catch (Exception $e) {
			throw new Exception('Error while persisting data source');	
		}

		return true;
	}

	public function getError()
	{
		return $this->error;
	}

}