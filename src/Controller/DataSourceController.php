<?php

namespace App\Controller;

use App\Entity\DataSource;
use App\Form\DataSource1Type;
use App\Repository\DataSourceRepository;
use App\Repository\ExperimentationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/source')]
class DataSourceController extends AbstractController
{
    #[Route('/', name: 'app_data_source_index', methods: ['GET'])]
    public function index(DataSourceRepository $dataSourceRepository): Response
    {
        return $this->render('data_source/index.html.twig', [
            'data_sources' => $dataSourceRepository->findAllWithExperimentationCount(),
        ]);
    }

    #[Route('/{id}/show', name: 'app_data_source_show', methods: ['GET'])]
    public function show(DataSource $dataSource, ExperimentationRepository $expRep): Response
    {   
        $nbExp = $expRep->countBySource($dataSource->getId());

        return $this->render('data_source/show.html.twig', [
            'data_source' => $dataSource,
            'nbExp' => $nbExp
        ]);
    }

    #[Route('/{id}/delete', name: 'app_data_source_delete', methods: ['POST'])]
    public function delete(Request $request, DataSource $dataSource, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dataSource->getId(), $request->request->get('_token'))) {

            try {
                $entityManager->remove($dataSource);
                $entityManager->flush();                
            }
            catch (\Exception $e)
            {
                $this->addFlash('error', 'Une erreur est survenue lors de la supperssion de la source');
            }

            try {
                $filepath = $this->getParameter('source_directory').'/'.$dataSource->getFilename();
                unlink($filepath);                
            }
            catch (\Exception $e)
            {
                $this->addFlash('error', 'Les données ont été supprimée mais une erreur est survenue lors de la suppression du fichier');
            }
        
        }

        return $this->redirectToRoute('app_data_source_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/exp/json', name: 'app_data_source_exp_as_json', methods: ['GET'])]
    public function expAsJson(DataSource $dataSource, ExperimentationRepository $expRep): Response
    {
        try {
            $result = $expRep->findBySource($dataSource->getId());            
        }
        catch(\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()]);
        }

        return new JsonResponse(['status' => 'success', 'data' => $result]);
    }
}
