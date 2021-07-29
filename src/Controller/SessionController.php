<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'session')]
    public function index(SessionRepository $repo, EntityManagerInterface $em): Response
    {
        $session = $repo->findAll();

        return $this->render('session/session.html.twig', [
            'sessions' => $session,
        ]);
    }
}
