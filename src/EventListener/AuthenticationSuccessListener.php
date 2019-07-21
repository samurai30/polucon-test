<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 13-07-2019
 * Time: 04:59 PM
 */

namespace App\EventListener;


use App\Entity\Users;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
 public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event){

     $data = $event->getData();
     $user = $event->getUser();

     if(!$user instanceof Users){
         return;
     }
     $data['id'] = $user->getId();

     $event->setData($data);
 }
}