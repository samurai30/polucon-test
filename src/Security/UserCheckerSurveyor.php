<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 08-07-2019
 * Time: 11:28 PM
 */

namespace App\Security;


use App\Entity\Users;
use App\Exceptions\ClientException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserCheckerSurveyor implements UserCheckerInterface
{

    /**
     * Checks the user account before authentication.
     *
     * @param UserInterface $user
     * @throws ClientException
     */
    public function checkPreAuth(UserInterface $user)
    {

       if (!$user instanceof Users){
           return;
       }

       if(!$user->getEnabled()){
           throw new AccessDeniedHttpException();
       }

       if (in_array($user->getRoles()[0],[Users::ROLE_SUPERADMIN,Users::ROLE_CLIENT])){
           throw new ClientException();
       }
    }

    public function checkPostAuth(UserInterface $user)
    {

    }
}