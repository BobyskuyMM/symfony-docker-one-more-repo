<?php

namespace App\EventListener;

use App\Event\SendInfoEmailEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendInfoEmailSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $parameterBag;
    
    public function __construct(MailerInterface $mailer, ParameterBagInterface $parameterBag)
    {
        $this->mailer = $mailer;
        $this->parameterBag = $parameterBag;
    }

    public static function getSubscribedEvents()
    {
        return [
            SendInfoEmailEvent::NAME => 'onSendInfoEmail'
        ];
    }

    public function onSendInfoEmail(SendInfoEmailEvent $event)
    {
        $data = $event->getData();
        $email = (new Email())
            ->to($data['email'])
            ->from($this->parameterBag->get('from_email'))
            ->subject($event->getCompany()->getName())
            ->text(
                sprintf("From %s to %s", $data['startDate'], $data['endDate'])
            )
        ;
        
        $this->mailer->send($email);
    }
}
