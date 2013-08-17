<?php

namespace Intervention\Image;

use \Imagine\Image\ImagineInterface;
use \Imagine\Image\ImageInterface;
use \Imagine\Image\Box;
use Exception;
use Closure;

class Image
{
    protected $imagine;
    protected $image;

    public $dirname;
    public $basename;
    public $extension;
    public $filename;

    public function __construct($imagine)
    {
        $this->setImagine($imagine);
    }

    public function getSize()
    {
        return $this->image->getSize();
    }

    public function getWidth()
    {
        return $this->image->getSize()->getWidth();
    }

    public function getHeight()
    {
        return $this->image->getSize()->getHeight();
    }

    public function make($source)
    {
        switch (true) {

            case $this->isStreamResource($source):
                $image = $this->read($source);
                break;

            case $this->isBinary($source):
                $image = $this->load($source);
                break;

            default:
                $image = $this->open($source);
                break;
        }

        return $image;
    }

    public function canvas($width, $height, $bgcolor = null)
    {
        # code...
    }

    /**
     * Read image data from image file path
     *
     * @param  string $path
     * @return Intervention\Image\Image
     */
    public function open($path)
    {
        $this->setFileInfoFromPath($path);
        $this->image = $this->imagine->open($path);

        return $this;
    }

    /**
     * Read image data from a binary string
     *
     * @param  string $string
     * @return Intervention\Image\Image
     */
    public function load($string)
    {
        $this->image = $this->imagine->load($string);

        return $this;
    }

    /**
     * Read image data form a resource stream
     *
     * @param  resource $resource
     * @return Intervention\Image\Image
     */
    public function read($resource)
    {
        $this->image = $this->imagine->read($resource);

        return $this;
    }

    public function resize($width = null, $height = null)
    {
        // get current image size
        $size = $this->image->getSize();

        // define new image size
        $width = is_numeric($width) ? intval($width) : $size->getWidth();
        $height = is_numeric($height) ? intval($height) : $size->getHeight();
        $size = new Box($width, $height);
        
        // resize image
        $this->image = $this->image->resize($size);

        return $this;
    }

    public function widen($width)
    {
        // get current image size
        $size = $this->image->getSize();

        // define new image size
        $size->widen($width);

        $this->image = $this->image->resize($size);

        return $this;
    }

    public function heighten($height)
    {
        // get current image size
        $size = $this->image->getSize();

        // define new image size
        $size->heighten($height);

        $this->image = $this->image->resize($size);

        return $this;
    }

    /**
     * Save image in filesystem
     *
     * @param  string  $path
     * @param  integer $quality
     * @return Intervention\Image\Image
     */
    public function save($path = null, $quality = 90)
    {
        // if path is not set, use current path of image
        $path = is_null($path) ? ($this->dirname .'/'. $this->basename) : $path;

        // save image
        $this->image->save($path, array('quality' => $quality));

        return $this;
    }

    public function getImagine()
    {
        return $this->imagine;
    }

    public function setImagine($imagine)
    {
        $this->imagine = $imagine;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($data)
    {
        $this->image = $data;
    }

    /**
     * Checks if string contains printable characters
     *
     * @param  mixed  $input
     * @return boolean
     */
    private function isBinary($input)
    {
        return ( ! ctype_print($input));
    }

    private function isStreamResource($input)
    {
        return (is_resource($input) && get_resource_type($input) == 'stream');
    }

    /**
     * Returns the currently used image library
     * 
     * @return string (gd|imagick|gmagick)
     */
    public function getDriverType()
    {
        switch (get_class($this->imagine)) {
            case 'Imagine\Gd\Imagine':
                $type = 'gd';
                break;

            case 'Imagine\Imagick\Imagine':
                $type = 'imagick';
                break;

            case 'Imagine\Gmagick\Imagine':
                $type = 'gmagick';
                break;
        }

        return $type;
    }

     /**
     * Set file info from image path in filesystem
     *
     * @param string $path
     */
    private function setFileInfoFromPath($path)
    {
        // set file info
        $info = pathinfo($path);
        $this->dirname = array_key_exists('dirname', $info) ? $info['dirname'] : null;
        $this->basename = array_key_exists('basename', $info) ? $info['basename'] : null;
        $this->extension = array_key_exists('extension', $info) ? $info['extension'] : null;
        $this->filename = array_key_exists('filename', $info) ? $info['filename'] : null;
    }
}
