<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Project;
use App\Form\CommentsType;
use App\Repository\CommentRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class TestController extends AbstractController
{
    #[Route('/project/{id}', name: 'project_show')]
    public function new(Project $project, Request $request, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $comment->setOwner($this->getUser());
            $comment->setProject($project);
            $commentRepository->add($comment, true);
            return $this->redirectToRoute('project_show', ['id' => $project->getId()]);
        }

        $projectComments = $commentRepository->findBy(['project' => $project]);

        return $this->render('test/project_show.html.twig', [
            'form'      => $form->createView(),
            'project'   => $project,
            'comments'  => $projectComments,
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

    #[Route('/add/favourite/{id}', name: 'add_favourite')]
    public function addFavourite(Project $project, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $user->addFavouriteProject($project);
        $userRepository->add($user, true);
        return $this->redirectToRoute('dashboard');
    }

    #[Route('/add/like/{id}', name: 'add_like')]
    public function addLike(Project $project, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $user->addLikedProject($project);
        $userRepository->add($user, true);
        return $this->redirectToRoute('dashboard');
    }
}
