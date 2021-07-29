<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function user(): Response
    {
        $user = $this->getUser();
        return $this->render('user/user.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/edit/{id}', name: 'user_edit_user')]
    public function editUser(User $user, EntityManagerInterface $em, Request $req): Response
    {
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('user');
        }
        return $this->render('user/edit-user.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    #[Route('/user/booking', name: 'booking')]
    public function booking(): Response
    {
        // $booking = $this->getUser();
        return $this->render('user/booking.html.twig', [
            // 'booking' => $booking,
        ]);
    }
}
