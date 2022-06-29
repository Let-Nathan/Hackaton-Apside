<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\UserProjectGranted;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/project/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProjectRepository $projectRepository)
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        $userProject = new UserProjectGranted();
        $userProject->setIsGranted(true);
        $project->addUserProject($userProject);

        if ($form->isSubmitted() && $form->isValid()) {

            dd($project);
//            $projectRepository->add($project, true);
        }

        return $this->renderForm('project/new.html.twig', [
            'form' => $form,
        ]);
    }
}
