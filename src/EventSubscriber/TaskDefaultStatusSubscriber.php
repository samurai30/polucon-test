<?php


namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Tasks;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TaskDefaultStatusSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return[
            KernelEvents::VIEW => ['addStatus',EventPriorities::PRE_WRITE]
        ];
    }

    public function addStatus(ViewEvent $event){
        $request = $event->getRequest();
        $method = $request->getMethod();
        $entity = $event->getControllerResult();

        if (!$entity instanceof Tasks || !in_array($method,[Request::METHOD_POST])){
            return;
        };

        $entity->setStatus('Pending');
    }
}