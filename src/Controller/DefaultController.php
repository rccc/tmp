<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Entity\Experimentation;
use App\Form\DataSourceType;
use App\Form\SearchType;
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
                
                $ret = $importer->import($file);

                if($ret)
                {
                    $this->addFlash('success', 'Data imported successfully');

                    $dataSource = $importer->getDataSource();

                    if($dataSource){
                        return $this->redirectToRoute('app_data_source_show', ['id' => $dataSource->getId()]);
                    }
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

        /*
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
        */

        $arr = [
            "numero-experimentation" => null,
            "type-experimentation" => null,
            "site-essai" => null,
            "systeme-essai" => null,
            "lot-cellules" => null,
            "passage" => null,
            "stress" => null,
            "temps-traitement" => null,
            "genes-analyses" => null,
            "proteine-correspondante" => null,
            "proteines-analysees" => null,
            "gene-correspondant" => null,
            "projet" => null,
            "nom-item" => null,
            "numero-item" => null,
            "type-echantillon" => null,
            "nom-r-et-d" => null,
            "nom-commercial" => null,
            "reference-produit" => null,
            "pourcentage-produit" => null,
            "genre" => null,
            "espece" => null,
            "fold-change" => null,
            "augmentation-diminution" => null,
            "notation" => null
        ];

        try
        {
            $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

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

    #[Route('/search', name: 'app_search')]
    public function search(Request $request, EntityManagerInterface $manager): Response
    {
        $numExpList     = $manager->getRepository(Experimentation::class)->getNumExpListAsChoiceList();
        $typeExpList    = $manager->getRepository(Experimentation::class)->getTypeExpListAsChoiceList();
        $nomCommList    = $manager->getRepository(Experimentation::class)->getNomCommListAsChoiceList();
        $sysEssaiList   = $manager->getRepository(Experimentation::class)->getSystEssaiListAsChoiceList();
        $projectList    = $manager->getRepository(Experimentation::class)->getProjectListAsChoiceList();
        $numItemList    = $manager->getRepository(Experimentation::class)->getNumItemListAsChoiceList();
        $genreList      = $manager->getRepository(Experimentation::class)->getGenreListAsChoiceList();
        $especeList     = $manager->getRepository(Experimentation::class)->getEspeceListAsChoiceList();

        $siteEssaiList          = $manager->getRepository(Experimentation::class)->getSiteEssaiListAsChoiceList();
        // $protCorrList     = $manager->getRepository(Experimentation::class)->getProtCorrListAsChoiceList();
        $lotCellList            = $manager->getRepository(Experimentation::class)->getLotCellListAsChoiceList();
        $passageList            = $manager->getRepository(Experimentation::class)->getPassageListAsChoiceList();
        $notationList           = $manager->getRepository(Experimentation::class)->getNotationListAsChoiceList();
        $typeEchantillonList    = $manager->getRepository(Experimentation::class)->getTypeEchantillonListAsChoiceList();


        $form =  $this->createForm(SearchType::class, null, [
            'num_exp'       => $numExpList,
            'type_exp'      => $typeExpList,
            'nom_comm'      => $nomCommList,           
            'syst_essai'    => $sysEssaiList,
            'project'       => $projectList,
            'num_item'       => $numItemList,
            'genre'         => $genreList,
            'espece'        => $especeList,
            'lot_cell'      => $lotCellList,
            'passage'       => $passageList,
            'notation'      => $notationList,
            'type_echantillon' => $typeEchantillonList
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            try{
                     
                $dto = $form->getData();

                $results = $manager->getRepository(Experimentation::class)->search($form->getData());

                if($form->get('export')->isClicked())
                {
                    $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

                    // encoding contents in CSV format
                    $content = $serializer->encode($results, 'csv');

                    $response = new Response($content);

                    $disposition = HeaderUtils::makeDisposition(
                        HeaderUtils::DISPOSITION_ATTACHMENT,
                        'template.csv'
                    );

                    $response->headers->set('Content-Disposition', $disposition);

                    return $response;
                }
                else
                {
                    return new JsonResponse(['status' => 'success', 'data' => $results]);
                }

            }catch(\Exception $e)
            {
                return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()]);                
            }
        }

        return $this->render('default/search.html.twig', [
            'form' => $form
        ]);
    }

}
