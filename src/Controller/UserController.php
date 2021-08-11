<?php

namespace App\Controller;

use App\Entity\Day;
use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\DayRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
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
    public function booking(Request $request, EntityManagerInterface $em, DayRepository $repo): Response
    {
        $day = new Day();

        $date = new \DateTime($request->request->get("date"));
        $day->setDate($date);
        $slot = explode(":", $request->request->get("heure"))[0];
        $colonne = "setSlot{$slot}h";
        //dd($repo->findOneByDate($request->request->get("date")));
        if (method_exists($day, $colonne)) {
            if (method_exists($day, $colonne)) {
                //true
                $day_bdd = $repo->findOneByDate($request->request->get("date")); // repoDate search if date exists 
                $day_bdd->$colonne($this->getUser()->getId());
                //dd($day_bdd);
                $em->persist($day_bdd);
                $em->flush();  // true update the row
                return $this->render('user/booking.html.twig', []);
            } else {
                // false
                $day->$colonne($this->getUser()->getId());
                $em->persist($day);
                $em->flush();
                return $this->render('user/booking.html.twig', []);
            }
        }
        return $this->redirect("/session");
    }

    #[Route('/user/generatePDF', name: 'pdf')]
    public function generatePDF()
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        //instanciation
        $domPdf = new Dompdf($pdfOptions);
        //generate html
        $html = $this->render('user/generatePDF.html.twig', []);
        $domPdf->loadHtml($html);
        $domPdf->setPaper('A4', 'portrait');
        $domPdf->render();
        //send pdf to browser
        $domPdf->stream("reservation.pdf", [
            'Attachment' => true
        ]);
        return new Response();
    }
}
