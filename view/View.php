<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\View\Page;

/**
 *  Swift View.
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
        /*
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
        /*
         *  @var void
         */
        $this->data->replace(
            gettype($dir) === 'array' ?
                $dir : [
                    $dir => $ext,
                ]
        );

        return $this;
    }

    /**
     *  @param $dir
     *  @param null $ext
     */
    public function register($dir, $ext = null)
    {
        /*
         *  @var void
         */
        return $this->add($dir, $ext);
    }

    /**
     *  @param  string  $file
     *  @param  array   $data
     *  @param  bool $prevent
     *
     *  @return \Frame\View\Page
     */
    public function make($file, array $data = [], $prevent = false)
    {
        /*
         *  @var \Frame\View\Page
         */
        return new Page(
            $this, $file, $data, $prevent
        );
    }

    /**
     * @param $file
     * @param null $ext
     *
     * @throws \Exception
     *
     * @return string
     */
    public function find($file, $ext = null)
    {
        /*
         *  @var iterable
         */
        foreach ($this->data as $dir => $_ext) {
            /**
             *  @var string
             */
            $path = sprintf(
                '%s/%s.%s', $dir, $file, $ext === null ? $_ext : $ext
            );

            /*
             *  @var boolean
             */
            if (is_file($path) === true) {
                /*
                 *  @var string
                 */
                return $path;
            }
        }

        /*
         *  @var \Exception
         */
        throw new \Exception(
            'File "'.$file.'" not found.'
        );
    }
}
