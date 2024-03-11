<?php

namespace App\Controller;

use App\Entity\DataSource;
use App\Form\DataSource1Type;
use App\Repository\DataSourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/{id}/delete', name: 'app_data_source_delete', methods: ['POST'])]
    public function delete(Request $request, DataSource $dataSource, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dataSource->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dataSource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_data_source_index', [], Response::HTTP_SEE_OTHER);
    }
}
