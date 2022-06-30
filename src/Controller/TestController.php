<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class TestController extends AbstractController
{
    #[Route('/project/{id}', name: 'project_show')]
    public function new(Project $project): Response
    {
      return $this->render('test/test.html.twig', [
          'project' => $project,
      ]);
    }

    #[Route('/test', name: 'test')]
    public function test(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('test/test.html.twig', [
            'users' => $users,
        ]);
    }
}
