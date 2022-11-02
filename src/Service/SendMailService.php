<?php

namespace App\Service;

use App\Entity\Mail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;


class SendMailService
{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notify(Mail $email): bool
    {
        $mail = (new TemplatedEmail())
            ->from($email->getEmail())
            ->to('contact@agence.ch')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            ->replyTo($email->getEmail())
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Agence : ' . $email->getProperty()->getTitle())
            ->htmlTemplate('emails/contact.html.twig')
            ->context(['contact' => $email]);

        try {
            $this->mailer->send($mail);
            return true;
        }catch(TransportExceptionInterface $exception){
            return false;
        }
    }

}