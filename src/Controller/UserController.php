<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $usersData[] = [
                'id' => $user->getId(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'email' => $user->getEmail(),
                'img' => $user->getImageUrl(),
                'agency' => $user->getAgency(),
            ];
        }

        return $this->json([
            'users' => $usersData,
        ]);
    }
}
