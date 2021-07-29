<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(GameRepository $repo): Response
    {
        $games = $repo->findAll();
        return $this->render('main/home.html.twig', [
            'games' => $games,
        ]);
    }
}
