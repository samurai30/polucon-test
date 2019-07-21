<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 11-07-2019
 * Time: 03:22 PM
 */

namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\CreatedDateInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class CreatedDateSubscriber implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
       return [
         KernelEvents::VIEW => ['setCreatedDate',EventPriorities::PRE_WRITE]
       ];
    }

    public function setCreatedDate(ViewEvent $event){
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if(!$entity instanceof CreatedDateInterface || Request::METHOD_POST !== $method){
            return;
        }
        try {
            $entity->setCreatedDate(new \DateTime());
        } catch (\Exception $e) {
            throw new NotFoundHttpException("SORRY SOMETHING WENT WRONG");
        }

    }
}