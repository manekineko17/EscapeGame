<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'game')]
    public function index(GameRepository $repo): Response
    {
        $games = $repo->findAll();

        return $this->render('game/game.html.twig', [
            'games' => $games,
        ]);
    }
}
