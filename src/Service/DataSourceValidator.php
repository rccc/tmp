<?php

namespace App\Service;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\String\Slugger\SluggerInterface;

class DataSourceValidator
{
	private $error;

	private $validHeaders = [
		"numero-experimentation",
		"type-experimentation",
		"site-essai",
		"systeme-essai",
		"lot-cellules",
		"passage",
		"stress",
		"temps-traitement",
		"genes-analyses",
		"proteine-correspondante",
		"proteines-analysees",
		"gene-correspondant",
		"projet",
		"nom-item",
		"numero-item",
		"type-echantillon",
		"nom-r-et-d",
		"nom-commercial",
		"reference-produit",
		"pourcentage-produit",
		"genre",
		"espece",
		"fold-change",
		"augmentation-diminution",
		"notation"
	];

	public function __construct(
        private string $targetDirectory,
        private SluggerInterface $slugger
	) {
	}

	public function validate(string $filename): bool
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
			return false;
		}

		$isNotEmpty = $this->validateIsnotEmpty(array_slice($data, 1, 10));

		if(!$isNotEmpty)
		{
			$this->error = 'Data source seems to be empty';
			return false;
		}

		return true;
	}

	public function validateHeaders(array $rawHeaders): bool
	{	

		// return true;
		$arr = [];
		$headers 	= array_map('trim',$rawHeaders);
		$headers 	= array_map(fn($header):string => strtr($header, $arr), $headers);
		$headers 	= array_map(fn($header):string => $this->slugger->slug($header)->lower(), $headers);

		try
		{
			$diff = array_diff($this->validHeaders, $headers);

			if(count($diff) == 0)
			{
				return true;
			}
			else
			{
				$this->error = 'Data source columns headers does not match: ' . implode(', ', $diff);
				return false;
			}
		}
		catch(\Exception $e)
		{
			$this->error = $e->getMessage();
			return false;
		}

	}

	public function validateIsnotEmpty(array $rows): bool
	{
		if(empty($rows))
		{
			return false;
		}

		foreach($rows as $row)
		{
			if(empty($row))
			{
				return false;
			}

			foreach($row as $column)
			{
				if(!empty($column))
				{
					return true;
				}
			}
		}

		return true;
	}

	public function getError()
	{
		return $this->error;
	}
}