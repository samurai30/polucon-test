<?php


namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Images;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

class RemoveImageSubscriber implements EventSubscriberInterface
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public static function getSubscribedEvents()
    {
       return[
           KernelEvents::VIEW => ['deleteImage',EventPriorities::PRE_WRITE]
       ];

    }

    public function deleteImage(ViewEvent $event){
        $entity = $event->getControllerResult();
        $request = $event->getRequest();
        $method = $request->getMethod();

        if(!$entity instanceof Images || !in_array($method,[Request::METHOD_DELETE])){
            return;
        }
        $url = $entity->getUrl();

        $dir = $this->kernel->getProjectDir();
        $delete_path = str_replace("/images/users",$dir."/public/images/users",$url);
        unlink($delete_path);
    }
}