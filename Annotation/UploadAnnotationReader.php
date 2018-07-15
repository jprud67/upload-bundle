<?php
namespace Jprud67\UploadBundle\Annotation;


use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UploadAnnotationReader
{
    /**
     * @var AnnotationReader
     */
    private $reader;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(AnnotationReader $reader,ContainerInterface $container)
    {
        $this->reader = $reader;
        $this->container = $container;
    }

    /**
     * @param $entity object
     * @return bool
     */
    public function isUploadable($entity){
        if(!is_object($entity)){
            throw new \InvalidArgumentException("The argument must be an Object");
        }
        $reflection=$this->container->get('jprud67_upload.utility')->getReflection($entity);
        return $this->reader->getClassAnnotation($reflection,Uploadable::class) != null;
    }

    /**
     * @param $entity object
     * @return array
     */
    public function getUploadField($entity){
        if(!$this->isUploadable($entity)){
            return [];
        }
        $reflection=$this->container->get('jprud67_upload.utility')->getReflection($entity);
        $properties=[];
        foreach ($reflection->getProperties() as $property) {
            $annotation=$this->reader->getPropertyAnnotation($property,UploadableField::class);
            if($annotation !== null){
                $properties[$property->getName()]=$annotation;
            }
        }
        return $properties;
    }

}