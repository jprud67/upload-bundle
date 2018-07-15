<?php
namespace Jprud67\UploadBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\EventArgs;
use Jprud67\UploadBundle\Annotation\UploadAnnotationReader;
use Jprud67\UploadBundle\Handler\UploadHandler;


class UploadSubscriber implements EventSubscriber
{

    /**
     * @var UploadAnnotationReader
     * */
    private $reader;

    /**
     * @var UploadHandler
     * */
    private $handler;


    function __construct(UploadAnnotationReader $reader, UploadHandler $handler)
    {
        $this->reader=$reader;
        $this->handler=$handler;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'postLoad',
            'preUpdate',
            'postRemove',
        ];
    }

    /**
     *
     * @param EventArgs $event
     */
    public function prePersist(EventArgs $event)
    {
        $this->preEvent($event);
    }

    /**
     *
     * @param EventArgs $event
     */
    public function preUpdate(EventArgs $event)
    {
        $this->preEvent($event);
    }

    /**
     *
     * @param EventArgs $event
     */
    public function preEvent(EventArgs $event)
    {
        $entity= $event->getEntity();
        foreach ($this->reader->getUploadField($entity) as $property => $annotation) {

            $this->handler->UploadFile($entity, $property,$annotation);

        }

        //throw new \Exception("Error Processing Request", 1);

    }

    /**
     *
     * @param EventArgs $event
     */
    public function postRemove(EventArgs $event)
    {
        $entity= $event->getEntity();
        foreach ($this->reader->getUploadField($entity) as $property => $annotation) {

            $this->handler->RemoveFile($entity, $property);

        }
    }


    /**
     *
     * @param EventArgs $event
     */
    public function postLoad(EventArgs $event)
    {
        $entity= $event->getEntity();
        foreach ($this->reader->getUploadField($entity) as $property => $annotation)
        {
            $this->handler->setFileFromFilename($entity, $property,$annotation);
        }
    }

}