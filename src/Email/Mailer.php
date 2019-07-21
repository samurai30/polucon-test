<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 09-07-2019
 * Time: 11:49 PM
 */

namespace App\Email;


use App\Entity\Users;
use Symfony\Bundle\TwigBundle\DependencyInjection\TwigExtension;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var TwigExtension|\Twig_Environment
     */
    private $twig;


    /**
     * Mailer constructor.
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $twig
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;

        $this->twig = $twig;
    }

    public function sendConfrimationEmail(Users $users){
        $body = $this->twig->render('email/confirmation.html.twig',[
            'user' => $users
        ]);

        $message = (new \Swift_Message('Please Verify E-mail: Polucon'))
            ->setFrom('samurai3095@gmail.com')
            ->setTo($users->getEmail())
            ->setBody($body, 'text/html');
        $this->mailer->send($message);
    }

}