<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Service\Exception\DataSourceUploaderException;

class DataSourceUploader
{
    private $filename;

    public function __construct(
        private string $targetDirectory,    
        private SluggerInterface $slugger,
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        try {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $this->filename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();            
        } catch (Exception $e) {
            throw new DataSourceUploaderException($e->getMessage());            
        }

        try {
            $file->move($this->getTargetDirectory(), $this->filename);
        } catch (FileException $e) {
            throw new DataSourceUploaderException($e->getMessage());
        }

        return $this->filename;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    public function deleteFile(): bool
    {
        if(!$this->filename)
        {
            return false;
        }

        $filepath = $this->getTargetDirectory().'/'.$this->filename;

        if(file_exists($filepath))
        {
            try {
                unlink($filepath);
                return true;
            } catch (Exception $e) {
            }
        }

        return false;
    }
}