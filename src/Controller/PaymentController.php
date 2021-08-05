<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'payment')]
    public function index(): Response
    {
        // affiche résumé réservation : nom game, nb participants, tarif total
        //plateforme de paiement
        return $this->render('payment/payment.html.twig', [
            'controller_name' => 'PaiementController',
        ]);
    }
}
