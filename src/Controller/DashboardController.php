<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\User;
use App\Form\SearchProjectType;
use App\Repository\ProjectRepository;
use App\Repository\TechnologyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function view(ProjectRepository $projectRepository, TechnologyRepository $technologyRepository, Request $request): Response
    {
        $searchForm = $this->createForm(SearchProjectType::class);
        $searchForm->handleRequest($request);

        if( $searchForm->isSubmitted() && $searchForm->isValid() ) {
            $search = $searchForm->get('title')->getData();
            $program = $projectRepository->findTitleTag($search);
            if(empty($program)) {
                $this->addFlash('primary', 'No project fund');
                return $this->redirectToRoute('dashboard');
            }
            return $this->render('dashboard.html.twig', [
                'project' => $program,
                'form' => $searchForm->createView(),
                'skills' => $technologyRepository->findAll(),
                ]);
        }

        return $this->render('dashboard.html.twig', [
            'project' => $projectRepository->findAll(),
            'form' => $searchForm->createView(),
            'skills' => $technologyRepository->findAll(),
        ]);
    }

    #[Route('/favourites', name: 'app_favourites')]
    public function favourites(ProjectRepository $projectRepository, TechnologyRepository $technologyRepository, Request $request): Response
    {
        $searchForm = $this->createForm(SearchProjectType::class);
        $searchForm->handleRequest($request);

        if( $searchForm->isSubmitted() && $searchForm->isValid() ) {
            $search = $searchForm->get('title')->getData();
            $program = $projectRepository->findTitleTag($search);
            if(empty($program)) {
                $this->addFlash('primary', 'No project fund');
                return $this->redirectToRoute('dashboard');
            }
            return $this->render('dashboard.html.twig', [
                'project' => $program,
                'form' => $searchForm->createView(),
                'skills' => $technologyRepository->findAll(),
                ]);
        }

        return $this->render('dashboard.html.twig', [
            'project' => $this->getUser()->getFavouriteProjects(),
            'form' => $searchForm->createView(),
            'skills' => $technologyRepository->findAll(),
        ]);
    }

    #[Route('/mostliked', name: 'app_mostliked')]
    public function mostliked(ProjectRepository $projectRepository, TechnologyRepository $technologyRepository, Request $request): Response
    {
        $searchForm = $this->createForm(SearchProjectType::class);
        $searchForm->handleRequest($request);

        if( $searchForm->isSubmitted() && $searchForm->isValid() ) {
            $search = $searchForm->get('title')->getData();
            $program = $projectRepository->findTitleTag($search);
            if(empty($program)) {
                $this->addFlash('primary', 'No project fund');
                return $this->redirectToRoute('dashboard');
            }
            return $this->render('dashboard.html.twig', [
                'project' => $program,
                'form' => $searchForm->createView(),
                'skills' => $technologyRepository->findAll(),
            ]);

        }
        $projects = $projectRepository->findAll();
        usort($projects, function (Project $p1, Project $p2){
            return count($p2->getUsersWhoLiked()) <=> count($p1->getUsersWhoLiked());
        });

        return $this->render('dashboard.html.twig', [
            'project' => $projects,
            'form' => $searchForm->createView(),
            'skills' => $technologyRepository->findAll(),
        ]);
    }

    #[Route('/projects/{techno}', name: 'app_projects_techno')]
    public function showByTechno(int $techno, TechnologyRepository $technologyRepository, ProjectRepository $projectRepository, Request $request): Response
    {
        $searchForm = $this->createForm(SearchProjectType::class);
        $searchForm->handleRequest($request);

        if( $searchForm->isSubmitted() && $searchForm->isValid() ) {
            $search = $searchForm->get('title')->getData();
            $program = $projectRepository->findTitleTag($search);
            if(empty($program)) {
                $this->addFlash('primary', 'No project fund');
                return $this->redirectToRoute('dashboard');
            }
            return $this->render('dashboard.html.twig', [
                'project' => $program,
                'form' => $searchForm->createView(),
                'skills' => $technologyRepository->findAll(),
                ]);
        }

        return $this->render('dashboard.html.twig', [
            'project' => $technologyRepository->findOneBy(['id' => $techno])->getProjects(),
            'form' => $searchForm->createView(),
            'skills' => $technologyRepository->findAll(),
        ]);
    }
}
