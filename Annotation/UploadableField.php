<?php
namespace Jprud67\UploadBundle\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class UploadableField
{
    /**
     * @string
    */
    private $filename;

    /**
     * @string
     */
    private $path;

    /**
     * UploadableField constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (!isset($options['filename'])){
            throw new \InvalidArgumentException("The UploadableField annotation must have a 'filename' attribute");
        }
        if (empty($options['filename'])){
            throw new \InvalidArgumentException("The 'filename' attribute of the UploadableField annotation must not be empty");
        }

        if (!isset($options['path'])){
            throw new \InvalidArgumentException("The UploadableField annotation must have a 'path' attribute");
        }

        if (empty($options['path'])){
            throw new \InvalidArgumentException("The 'path' attribute of the UploadableField annotation must not be empty");
        }

        $this->filename = $options['filename'];
        $this->path = $options['path'];
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

}