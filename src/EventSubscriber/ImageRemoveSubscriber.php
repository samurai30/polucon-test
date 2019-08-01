<?php


namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Images;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Vich\UploaderBundle\Handler\UploadHandler;
use Vich\UploaderBundle\VichUploaderBundle;

class ImageRemoveSubscriber implements EventSubscriberInterface
{

    /**
     * @var UploadHandler
     */
    private $handler;

    public function __construct(UploadHandler $handler)
    {

        $this->handler = $handler;
    }

    public static function getSubscribedEvents()
    {
        return[
          KernelEvents::VIEW => ['deleteImage',EventPriorities::PRE_WRITE]
        ];
    }
    public function deleteImage(ViewEvent $event){
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ( !$entity instanceof Images  || !in_array($method,[Request::METHOD_DELETE]))
        {
            return;
        }
        $this->handler->remove($entity,'file');
        $entity->setFile(null);
        $entity->setUrl(null);

    }
}