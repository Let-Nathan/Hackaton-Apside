<?php

namespace App\Controller;

use App\Form\SearchProjectType;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class dashboardController extends AbstractController
{
    #[Route('/', name:'dashboard')]
    public function view(ProjectRepository $projectRepository, Request $request, SearchProjectType $searchProjectType): Response
    {

        $searchForm = $this->createForm(SearchProjectType::class);
        $searchForm->handleRequest($request);
        if( $searchForm->isSubmitted() && $searchForm->isValid() ) {

            $search = $searchForm->get('title')->getData();
//            $program = $projectRepository->findBy(['title' => $search]);
            $program = $projectRepository->findTitleTag($search);
            if(empty($program)) {
                $this->addFlash('primary', 'No project fund');
                return $this->redirectToRoute('dashboard');
            }
            return $this->render('dashboard.html.twig', [
                'project' => $program,
                'form' => $searchForm->createView()]);
        }

        return $this->render('dashboard.html.twig', [
            'project' => $projectRepository->findAll(),
            'form' => $searchForm->createView()

        ]);
    }


}