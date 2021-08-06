<?php

namespace App\Controller;

use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Crypto\SMimeSigner;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/email', name: 'email')]
    public function sendEmail(MailerService $mailer, SMimeSigner $signer): Response
    {
        $mailer->send(
            'test@gmail.com',
            'mgrouiller@gmail.com',
            'test mailer service',
            'mailer/mailer.html.twig',
            ['name' => 'Test Test']
        );

        $signer = new SMimeSigner('/path/to/certificate.crt', '/path/to/certificate-private-key.key');
        // if the private key has a passphrase, pass it as the third argument
        // new SMimeSigner('/path/to/certificate.crt', '/path/to/certificate-private-key.key', 'the-passphrase');

        // $signedEmail = $signer->sign($email);
        // now use the Mailer component to send this $signedEmail instead of the original email



        // $template
        return $this->render('mailer/mailer.html.twig', [
            'email' => $mailer,
        ]);
    }
}
