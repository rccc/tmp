<?php

namespace App\Service;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class DataSourceValidator
{
	private $error;

	private $validHeaders = [
		'col1',
		'col2',
		'col3',
	];

	public function __construct(
        private string $targetDirectory
	) {
	}

	public function validate(string $filename)
	{
		$data = [];
		
		$filepath = $this->targetDirectory .'/'. $filename;

		if(!file_exists($filepath))
		{	
			$this->error = 'Data source file is missing';
			return false;
		}

		try {			
			$serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
			$data = $serializer->decode(file_get_contents($filepath), 'csv');

		} catch (Exception $e) {
			$this->error = 'Data source is not readable';
			return false;
		}

		if(empty($data) && !count($data) && empty(array_keys($data[0])))
		{  
			$this->error = 'Data source is empty or is not readable';
			return false;
		}

		$isValidHeaders = $this->validateHeaders(array_keys($data[0]));

		if(!$isValidHeaders)
		{
			$this->error = 'Data source columns headers does not match';
			return false;
		}

		return true;
	}

	public function validateHeaders(array $headers): bool
	{	
		// return true;

		try
		{
			$diff = array_diff($this->validHeaders, array_map('trim',$headers));
			return (count($diff) == 0);			
		}
		catch(\Exception $e)
		{
			return false;
		}

	}

	public function getError()
	{
		return $this->error;
	}
}