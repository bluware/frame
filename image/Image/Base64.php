<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Image;

use Frame\Image;

/**
 *  @subpackage File
 */
class Base64 extends \Frame\File\Base64
{
    /**
     *  @var array
     */
    protected $types    = [
        'image/gif', 'image/png', 'image/jpeg', 'image/bmp', 'image/webp'
    ];

    /**
     *  @var \Frame\Image
     */
    protected $image;

    /**
     *  @param  string $data
     *
     *  @return void
     */
    public function __construct($data, $name = null, $hash = 'md5')
    {
        parent::__construct($data, $name, $hash);

        if ($this->valid = false)
            return;

        $this->valid = false;

        /**
         *  @var resource
         */
        $resource = @imagecreatefromstring(
            $this->data
        );

        /**
         *  @var void
         */
        if ($resource === false)
            return;

        /**
         *  @var \Frame\Image
         */
        $this->image = new Image($resource);

        /**
         *  @var boolean
         */
        $this->valid = true;
    }

    /**
     *  @param  integer $w
     *  @param  integer $h
     *
     *  @return $this
     */
    public function resize($w, $h)
    {
        $this->image->resize($w, $h);

        return $this;
    }

    /**
     *  @param  integer $w
     *  @param  integer $h
     *
     *  @return $this
     */
    public function flip($orientation = 'horizontal')
    {
        $this->image->flip($orientation);

        return $this;
    }

    /**
     *  @param  integer $w
     *  @param  integer $h
     *
     *  @return $this
     */
    public function rotate($degrees = 90)
    {
        $this->image->rotate($degrees);

        return $this;
    }

    /**
     *  @param  integer $w
     *  @param  integer $h
     *
     *  @return $this
     */
    public function crop($w, $h)
    {
        $this->image->crop($w, $h);

        return $this;
    }

    /**
     *  @param  string  $file
     *  @param  integer $q
     *
     *  @return void
     */
    public function put($file, $q = 75)
    {
        $this->image->put($file, $q);

        return $this;
    }

    /**
     *  @param  string  $file
     *  @param  integer $q
     *
     *  @return void
     */
    public function jpeg($file, $q = 75)
    {
        $this->image->jpeg($file, $q);

        return $this;
    }

    /**
     *  @param  string  $file
     *  @param  integer $q
     *  @param  integer $filter
     *
     *  @return void
     */
    public function png($file, $q = 0, $filter = 0)
    {
        $this->image->png($file, $q, $filter);

        return $this;
    }

    /**
     *  @param  string  $file
     *
     *  @return void
     */
    public function gif($file)
    {
        $this->image->gif($file);

        return $this;
    }
}
