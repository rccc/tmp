<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
// use Doctrine\ORM\EntityManagerInterface;
use App\Entity\DataSource;
use App\Form\DataSourceType;
// use App\Service\DataSourceUploader;
// use App\Service\DataSourceValidor;
use App\Service\DataSourceImporter;
use App\Service\Exception\DataSourceImporterException;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(Request $request, DataSourceImporter $importer): Response
    {   
        $filename = null;

        $form =  $this->createForm(DataSourceType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {   
            $file = $form->get('source')->getData();
            
            try {
                
                $ret = $importer->import($file, new DataSource);

                if($ret)
                {
                    $this->addFlash('success', 'Data imported successfully');
                }
                else
                {
                    $this->addFlash('error', $importer->getError());
                }

            } catch (DataSourceImporterException $e) {
                $this->addFlash('error', $e->getMessage());
            }

        }
        
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'form' => $form
        ]);
    }
}
