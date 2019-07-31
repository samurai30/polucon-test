<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 21-07-2019
 * Time: 07:18 PM
 */

namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Exceptions\EmptyBodyException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Util\FormUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class EmptyBodySubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
       return[
           KernelEvents::REQUEST => ['handleEmptyBody', EventPriorities::POST_DESERIALIZE]
       ];
    }

    /**
     * @param RequestEvent $event
     * @throws EmptyBodyException
     */
    public function handleEmptyBody(RequestEvent $event){

        $request = $event->getRequest();
        $method = $request->getMethod();
        $route = $request->get('_route');
        if (!in_array($method,[Request::METHOD_POST,Request::METHOD_PUT])|| in_array($request->getContentType(),['html','form']) ||
            substr($route,0,3) !== 'api')
        {
            return;
        }
        $data = $event->getRequest()->get('data');
//        if ($data === null){
//            throw new EmptyBodyException();
//        }

    }
}