<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class dashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function view(ProjectRepository $projectRepository): Response
    {
        return $this->render('dashboard.html.twig', ['project' => $projectRepository]);
    }
}