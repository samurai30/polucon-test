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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
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
        $method = $event->getRequest()->getMethod();

        if (!in_array($method,[Request::METHOD_POST,Request::METHOD_PUT]))
        {
            return;
        }
        $data = $event->getRequest()->get('data');
        if (null === $data){
            throw new EmptyBodyException();
        }

    }
}