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
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'email' => $user->getEmail(),
            ];
        }

        return $this->json([
            'users' => $usersData,
        ]);
    }
}
