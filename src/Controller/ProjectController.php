<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/project/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProjectRepository $projectRepository, UserRepository $userRepository)
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($project->getUserProjects() as $el) {
                $el->setProject($project);
            }

            $projectRepository->add($project, true);
        }

        return $this->renderForm('project/new.html.twig', [
            'form' => $form,
            'project' => $project,
            'users' => $userRepository->findAll(),
        ]);
    }
}
