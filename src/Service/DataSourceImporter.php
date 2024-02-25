<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Service\DataSourceUploader;
use App\Service\DataSourceValidator;
use App\Service\DataSourcePersistor;
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
	    private DataSourcePersistor $persistor
	) {
	}
	
	public function import(UploadedFile $file)
	{
		$datasource;

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
			
			$this->persistDataSource();
			$this->persistExperimentations();

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



	public function getError()
	{
		return $this->error;
	}

	private function persistDataSource(): bool
	{
		$ret = $this->persistor->persistDataSource($this->filename);

		if(!$ret)
		{
			$this->uploader->deleteFile();

			throw new DataSourceImporterException('DataSourcePersister return false without exception');
		}	

		return $ret;
	}

	private function persistExperimentations()
	{
		try{

			$filepath = $this->uploader->getTargetDirectory() . '/'. $this->filename;

			if(!file_exists($filepath))
			{
				throw new DataSourceImporterException('source file does not exists');
			}

			$serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

			$csvData = $serializer->decode(file_get_contents($filepath), 'csv');    

			$ret = $this->persistor->persistExperimentations($csvData);


		}catch(\Exception $e)
		{
			throw new DataSourceImporterException($e->getMessage());
		}

		return true;
	}
}