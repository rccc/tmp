<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\Routing\Attribute\Route;
// use Doctrine\ORM\EntityManagerInterface;
use App\Form\DataSourceType;
use App\Service\DataSourceImporter;
use App\Service\Exception\DataSourceImporterException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
                
                $ret = $importer->import($file);

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

    #[Route('/empty-file', name: 'app_empty_file')]
    public function emptyFile()
    {   
        $content = '';
        $arr = [
            "Numéro expérimentation" => null,
            "Type expérimentation" => null,
            "Site essai" => null,
            "Système essai" => null,
            "Lot cellules" => null,
            "Passage" => null,
            "Stress" => null,
            "Temps traitement" => null,
            "Gènes analysés" => null,
            "Protéine correspondante" => null,
            "Protéines analysées" => null,
            "Gène correspondant" => null,
            "Projet" => null,
            "Nom item" => null,
            "Numéro item" => null,
            "Type échantillon" => null,
            "Nom R&D" => null,
            "Nom commercial" => null,
            "Référence produit" => null,
            "Pourcentage produit" => null,
            "Genre" => null,
            "Espèce" => null,
            "Fold change" => null,
            "% augmentation/diminution" => null,
            "Notation" => null
        ];

        try
        {
            $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

            // encoding contents in CSV format
            $content = $serializer->encode($arr, 'csv');            
        }
        catch(\Exception $e)
        {
            $this->addFlash('error', $e->getMessage());

            return $this->redirectToRoute('app_default');
        }

        $response = new Response($content);

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            'template.csv'
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
