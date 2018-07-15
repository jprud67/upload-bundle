<?php
namespace Jprud67\UploadBundle\Handler;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PropertyAccess\PropertyAccess;
use  Symfony\Component\HttpFoundation\File\File;



class UploadHandler
{

    private $accessor;

    function __construct()
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function uploadFile($entity, $property, $annotation)
    {
        $file = $this->accessor->getValue($entity, $property);


        if ($file instanceof UploadedFile) {
            $this->RemoveOldFile($entity, $annotation);
            $filename=$file->getClientOriginalName();
            $file->move($annotation->getPath(), $filename);
            $this->accessor->setValue($entity, $annotation->getFilename(), $filename);

        }

    }

    /**
     * @param $entity
     * @param $annotation
     */
    public function RemoveOldFile($entity, $annotation)
    {
        $file = $this->getFileFromFilename($entity, $annotation);

        if ($file !== null) {
            @unlink($file->getRealPath());
        }

    }

    /**
     * @param $entity
     * @param $property
     */
    public function RemoveFile($entity, $property)
    {
        $file = $this->accessor->getValue($entity, $property);


        if ($file instanceof File) {
            @unlink($file->getRealPath());
        }

    }

    /**
     * @param $entity
     * @param $property
     * @param $annotation
     */
    public function setFileFromFilename($entity, $property, $annotation)
    {
        $file = $this->getFileFromFilename($entity, $annotation);
        $this->accessor->setValue($entity, $property, $file);

    }


    /**
     * @param $entity
     * @param $annotation
     * @return null|File
     */
    private function getFileFromFilename($entity, $annotation)
    {
        $filename = $this->accessor->getValue($entity, $annotation->getFilename());

        if (empty($filename)) {
            return null;
        }
        else{
            return new File($annotation->getPath().DIRECTORY_SEPARATOR.$filename, false);
        }
    }

}