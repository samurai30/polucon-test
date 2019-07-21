<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 21-07-2019
 * Time: 07:46 PM
 */

namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Users;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class FetchSurveyors implements EventSubscriberInterface
{
    public function __construct()
    {
    }

    public static function getSubscribedEvents()
    {
        return[
          KernelEvents::VIEW =>['getSurveyors',EventPriorities::POST_SERIALIZE]
        ];
    }
    public function getSurveyors(ViewEvent $event){
        $method = $event->getRequest()->getMethod();
        $request = $event->getRequest();
        $users = json_decode($event->getControllerResult(),true);


//        foreach ($users as $key => $values){
//           if ($key === 'hydra:member'){
//               foreach ($values as $key2 => $value2){
//                   if ( in_array($value2['roles'][0],['ROLE_SUPERADMIN','ROLE_ADMIN','ROLE_SUBADMIN','ROLE_CLIENT']));
//
//               }
//           }
//        }

       if(!$users instanceof Users || in_array($method,[Request::METHOD_GET]) ||  'api_users_get-surveyor-list_collection ' !== $request->get('_route')){
           return;
       }


    }
}
