<?php

namespace App\Controller;

use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/email', name: 'email')]
    public function sendEmail(MailerService $mailer): Response
    {
            $mailer->send('test@gmail.com',
                        'mgrouiller@gmail.com',
                        'test mailer service',
                        'mailer/mailer.html.twig',
                        ['name'='Test Test'])

        // $template
        return $this->render('mailer/mailer.html.twig', [
            //$params

        ]);
    }
}
