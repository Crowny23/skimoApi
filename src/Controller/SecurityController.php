<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class SecurityController extends AbstractController
{
    #[Route(path: '/api/login', name: 'api_login')]
    public function index(#[CurrentUser] ?Users $user): Response 
    {
      if (null === $user) {
        return $this->json([
        'message' => 'missing credentials',
        'user' => $user,
        ], Response::HTTP_UNAUTHORIZED);
      }
      return $this->json([
        'user' => $user->getUserIdentifier(),
        'roles' => $user->getRoles()
      ]);
    }
}