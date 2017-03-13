<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Data;
use Frame\View\Page;

/**
 *  Swift View
 *
 *  @subpackage Swift
 */
class View implements ViewInterface
{
    /**
     *  @var array
     */
    protected $data = [];

    /**
     *  @return void
     */
    public function __construct()
    {
        /**
         *  @var \Frame\Data
         */
        $this->data = new Data();
    }

    /**
     *  @param mixed $dir
     *  @param mixed $ext
     *
     *  @return void
     */
    public function add($dir, $ext = null)
    {
        /**
         *  @var void
         */
        $this->data->replace(
            gettype($dir) === 'array' ?
                $dir : [
                    $dir => $ext
                ]
        );
    }

    /**
     *  @param mixed $dir
     *  @param mixed $ext
     *
     *  @return void
     */
    public function register($dir, $ext = null)
    {
        /**
         *  @var void
         */
        return $this->add($dir, $ext);
    }

    /**
     *  @param  string  $file
     *  @param  array   $data
     *  @param  boolean $prevent
     *
     *  @return \Frame\View\Page
     */
    public function make($file, array $data = [], $prevent = false) {
        /**
         *  @var \Frame\View\Page
         */
        return new Page(
            $this, $file, $data, $prevent
        );
    }

    /**
     *  @param  string $file
     *
     *  @return mixed
     */
    public function find($file, $ext = null)
    {
        /**
         *  @var iterable
         */
        foreach ($this->data as $dir => $_ext) {
            /**
             *  @var string
             */
            $path = sprintf(
                '%s/%s.%s', $dir, $file, $ext === null ? $_ext : $ext
            );

            /**
             *  @var boolean
             */
            if (is_file($path) === true)
                /**
                 *  @var string
                 */
                return $path;
        }

        /**
         *  @var \Exception
         */
        throw new \Exception(
            'File "' . $file . '" not found.'
        );
    }
}
