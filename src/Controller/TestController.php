<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class TestController extends AbstractController
{
    #[Route('/project/{id}', name: 'test', methods: ['GET', 'POST'])]
    public function new(Project $project): Response
    {
      return $this->render('test/test.html.twig', [
          'project' => $project,
      ]);
    }
}
