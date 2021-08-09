<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Session;
use App\Entity\User;
use App\Form\UserFormType;
use App\Form\AddGameFormType;
use App\Form\AddSessionFormType;
use App\Repository\DayRepository;
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

    /************************************** USERS ********************************************/
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
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/edit-user.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    /******************************************* GAME **************************************/
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
            return $this->redirectToRoute('admin_game');
        }
        return $this->render('admin/edit-game.html.twig', [
            'addGameForm' => $form->createView()
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

        return $this->render('admin/edit-game.html.twig', [
            'addGameForm' => $form->createView()
        ]);
    }

    /************************************ SESSION ****************************************/
    #[Route('/admin/session', name: 'admin_session')]
    public function index(DayRepository $repo): Response
    {
        $days_bdd = $repo->findAll();
        // dd($days_bdd);

        $beginDate = new \DateTime('2021-08-02');
        $endDate = new \DateTime('2021-08-07');

        $daterange = new \DatePeriod($beginDate, new \DateInterval('P1D'), $endDate);
        $dates = array();
        foreach ($daterange as $date) {
            $slots = array();
            $beginSlot = new \DateTime('09:00');
            $endSlot = new \DateTime('18:00');
            $slotRange = new \DatePeriod($beginSlot, new \DateInterval('PT1H'), $endSlot);
            foreach ($slotRange as $slot) {
                if ($slot->format("H:i") == "13:00") {
                    continue;
                }
                array_push($slots, $slot->format("H:i"));
            }
            $dates[$date->format("Y-m-d")] = $slots;
        }

        $dates_bdd = array();
        foreach ($days_bdd as $not_available) {
            $key = $not_available->getDate()->format("Y-m-d");
            $dates_bdd[$key] = [$not_available->getSlot9h(), $not_available->getSlot10h(), $not_available->getSlot11h(), $not_available->getSlot12h(), $not_available->getSlot14h(), $not_available->getSlot15h(), $not_available->getSlot16h(), $not_available->getSlot17h()];
        }

        // dd($dates);
        return $this->render('admin/session.html.twig', [
            'sessions' => $days_bdd,
            'dates' => $dates,
            "dates_bdd" => $dates_bdd
        ]);
    }

    #[Route('/admin/add-session', name: 'add_session')]
    public function addSession(Request $req, EntityManagerInterface $em): Response
    {
        $session = new Session();
        $form = $this->createForm(AddSessionFormType::class, $session);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($session);
            $em->flush();
            return $this->redirectToRoute('admin_session');
        }
        return $this->render('admin/add-session.html.twig', [
            'addSessionForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/delete-session/{id}', name: 'delete_session')]
    public function deleteSession(Session $session, EntityManagerInterface $em): Response
    {
        $em->remove($session);
        $em->flush();
        return $this->redirectToRoute('admin_session');
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
