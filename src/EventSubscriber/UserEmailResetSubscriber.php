<?php


namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Email\Mailer;
use App\Entity\Users;
use App\Security\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserEmailResetSubscriber implements EventSubscriberInterface
{

    /**
     * @var TokenGenerator
     */
    private $generator;
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(TokenGenerator $generator, Mailer $mailer,EntityManagerInterface $manager)
    {
        $this->generator = $generator;
        $this->mailer = $mailer;
        $this->manager = $manager;
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::VIEW =>['resetEmail',EventPriorities::PRE_WRITE]];
    }

    public function resetEmail(ViewEvent $event){

        $user = $event->getControllerResult();
        $request = $event->getRequest();
        if(!$user instanceof Users || 'api_users_put-reset-email_item' !== $request->get('_route') ){
            return;
        }
        $user->setEnabled(false);
        $user->setConfirmationToken($this->generator->getRandomSecureToken());
        $this->mailer->sendConfrimationEmail($user);

    }
}