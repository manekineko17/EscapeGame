<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Session;
use App\Entity\User;
use App\Form\UserFormType;
use App\Form\AddGameFormType;
use App\Form\AddSessionFormType;
use App\Repository\GameRepository;
use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/game', name: 'admin_game')]
    public function home(): Response
    {
        return $this->render('admin/game.html.twig');
    }

    /******************************** USERS *******************************/
    #[Route('/admin/users', name: 'admin_users')]
    public function users(
        UserRepository $repo,
    ): Response {

        $users = $repo->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/delete-user/{id}', name: 'admin_delete_user')]
    public function deleteUser(User $user, EntityManagerInterface $em): Response
    {
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('admin_users');
    }

    #[Route('/admin/edit-user/{id}', name: 'admin_edit_user')]
    public function editUser(User $user, EntityManagerInterface $em, Request $req): Response
    {
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit-user.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    /********************************* scenario ******************************/
    #[Route('/admin/game', name: 'admin_game')]
    public function game(GameRepository $repo): Response
    {
        $game = $repo->findAll();
        return $this->render('admin/game.html.twig', [
            'games' => $game,
        ]);
    }

    #[Route('/admin/add-game', name: 'admin_add_game')]
    public function addGame(Request $req, EntityManagerInterface $em): Response
    {
        $game = new Game();
        $form = $this->createForm(AddGameFormType::class, $game);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($game);
            $em->flush();
        }
        return $this->render('admin/edit-game.html.twig', [
            'addGameForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/delete-game/{id}', name: 'delete_game')]
    public function deleteGame(Game $game, EntityManagerInterface $em): Response
    {
        $em->remove($game);
        $em->flush();
        return $this->redirectToRoute('admin_game');
    }

    #[Route('/admin/edit-game/{id}', name: 'edit_game')]
    public function editGame(Game $game, EntityManagerInterface $em, Request $req): Response
    {
        $form = $this->createForm(AddGameFormType::class, $game);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('admin_game');
        }

        return $this->render('admin/game.html.twig', [
            'editGameForm' => $form->createView()
        ]);
    }

    /****************************** SESSION **********************************/
    #[Route('/admin/session', name: 'admin_session')]
    public function index(SessionRepository $repo): Response
    {
        $session = $repo->findAll();

        return $this->render('admin/session.html.twig', [
            'sessions' => $session,
        ]);
    }

    #[Route('/admin/add-session', name: 'admin_add_session')]
    public function addSession(Request $req, EntityManagerInterface $em): Response
    {
        $session = new Session();
        $form = $this->createForm(AddSessionFormType::class, $session);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($session);
            $em->flush();
        }
        return $this->render('admin/edit-session.html.twig', [
            'addSessionForm' => $form->createView(),
        ]);
    }


    /*************************** REDIRECTION ****************************/

    #[Route('/redirection', name: 'redirection')]
    public function redirection()
    {
        $role = $this->getUser()->getRoles();
        if ($role[0] == 'ROLE_USER') {
            return $this->redirectToRoute('booking');
        } else if ($role[0] == 'ROLE_ADMIN') {
            return $this->redirectToRoute('admin_game');
        } else
            return $this->redirectToRoute('home');
    }
}
