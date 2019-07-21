<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 08-07-2019
 * Time: 11:28 PM
 */

namespace App\Security;


use App\Entity\Users;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserEnabledChecker implements UserCheckerInterface
{

    /**
     * Checks the user account before authentication.
     *
     * @param UserInterface $user
     */
    public function checkPreAuth(UserInterface $user)
    {
       if (!$user instanceof Users){
           return;
       }

       if(!$user->getEnabled()){
           throw new AccessDeniedHttpException();
       }
    }

    public function checkPostAuth(UserInterface $user)
    {

    }
}