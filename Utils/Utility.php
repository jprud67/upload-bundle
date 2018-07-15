<?php

namespace Jprud67\UploadBundle\Utils;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 *
 * @author Prudence Assogba <jprud67@gmail.com>
 */
class Utility
{

    /**
     *@var ObjectManager
     */
    private $manager;

    /*
    * @var object
    */
    private $container;


    public function __construct(ObjectManager $manager,ContainerInterface $container)
    {
        $this->manager = $manager;
        $this->container = $container;
    }

    /**
     * @param $entity object
     * @return \ReflectionClass
     */
    public function getReflection($entity){
        return new \ReflectionClass(get_class($entity));
    }
}
