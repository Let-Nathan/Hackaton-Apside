<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/api/users/{search}', name: 'api_users', methods: ['GET'])]
    public function findByLike($search, UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findByLike($search);

        $usersData = [];
        foreach ($users as $user)
        {
            $skills = [];
            foreach ($user->getTechnologies() as $technology)
            {
                $skills[] = $technology->getName();
            }
            $usersData[] = [
                'id' => $user->getId(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'email' => $user->getEmail(),
                'img' => $user->getImageUrl(),
                'agency' => $user->getAgency(),
                'skills' => $skills,
            ];
        }

        return $this->json([
            'users' => $usersData,
        ]);
    }

    #[Route('/profile', name: 'app_user')]
    public function profile(): Response
    {
        return $this->render('profile.html.twig');
    }
}
