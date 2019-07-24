<?php


namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Email\Mailer;
use App\Entity\Users;
use App\Security\TokenGenerator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRegisterSubscriber implements EventSubscriberInterface
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var TokenGenerator
     */
    private $tokenGenerator;
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(UserPasswordEncoderInterface $encoder,TokenGenerator $tokenGenerator,Mailer $mailer,TokenStorageInterface $tokenStorage)
    {
        $this->encoder = $encoder;
        $this->tokenGenerator = $tokenGenerator;
        $this->mailer = $mailer;

        $this->tokenStorage = $tokenStorage;
    }


    public static function getSubscribedEvents()
    {
        return [
          KernelEvents::VIEW => ['userRegistered',EventPriorities::PRE_WRITE]
        ];
    }
    public function userRegistered(ViewEvent $event)
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $authUserRole = $this->tokenStorage->getToken()->getUser()->getRoles()[0];

        if(!$user instanceof Users || !in_array($method,[Request::METHOD_POST])){
            return;
        }
        //Deny permission for admins to create SUPER-ADMIN AND ADMIN
        if ( in_array($user->getRoles()[0],
                [Users::ROLE_SUPERADMIN,Users::ROLE_ADMIN])
            && $authUserRole === Users::ROLE_ADMIN)
        {
            throw new AccessDeniedHttpException("Sorry Admins don't have permission to create ".$user->getRoles()[0]);
        }
        //Deny permission for sub-admins to create SUPER-ADMIN AND ADMIN AND SUB-ADMIN
        if (in_array($user->getRoles()[0],
                [Users::ROLE_SUPERADMIN,Users::ROLE_ADMIN,Users::ROLE_SUBADMIN])
            && $authUserRole === Users::ROLE_SUBADMIN)
        {
            throw new AccessDeniedHttpException("Sorry Sub-Admins don't have permission to create ".$user->getRoles()[0]);
        }
        //Deny permission for clients and surveyors to create SUPER-ADMIN, ADMIN, SUB-ADMIN, CLIENT AND SURVEYOR
        if (in_array($user->getRoles()[0],
                [Users::ROLE_SUPERADMIN,Users::ROLE_ADMIN,Users::ROLE_SUBADMIN,Users::ROLE_CLIENT,Users::ROLE_SURVEYOR])
            && $authUserRole === Users::ROLE_CLIENT
            || $authUserRole === Users::ROLE_SURVEYOR)
        {
            throw new AccessDeniedHttpException("Sorry you don't have permission to create ".$user->getRoles()[0]);
        }


        // Hash Password Here
        $user->setPassword($this->encoder->encodePassword($user,$user->getPassword()));
        // Create confirmation Token
        $user->setConfirmationToken($this->tokenGenerator->getRandomSecureToken());
        //Confirmation Mail
        $this->mailer->sendConfrimationEmail($user);


    }
}