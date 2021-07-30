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

        $tabWeek = [
            [
                0 => '8h-9h',
                1 => '',
                2 => '',
                3 => '',
                4 => '',
                5 => '',
                6 => '16h-17h',
            ],
            [
                0 => '8h-9h',
                1 => '',
                2 => '',
                3 => '',
                4 => '',
                5 => '',
                6 => '',
            ],
            [
                0 => '8h-9h',
                1 => '',
                2 => '',
                3 => '',
                4 => '',
                5 => '',
                6 => '',
            ],
            [
                0 => '8h-9h',
                1 => '',
                2 => '',
                3 => '',
                4 => '',
                5 => '',
                6 => '',
            ],
            [
                0 => '8h-9h',
                1 => '',
                2 => '',
                3 => '',
                4 => '',
                5 => '',
                6 => '',
            ],
            [
                0 => '8h-9h',
                1 => '',
                2 => '',
                3 => '',
                4 => '',
                5 => '',
                6 => '',
            ]
        ];

        return $this->render('session/session.html.twig', [
            'sessions' => $session,
            'tabWeek' => $tabWeek
        ]);
    }
}
