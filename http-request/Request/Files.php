<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Http\Request;

use Frame\Data\Readable;
use Frame\Http\File;

/**
 * @subpackage Request
 */
class Files extends Readable
{
    /**
     *  @param mixed $data
     */
    public function __construct(array $data = null)
    {
        if ($data !== null)
            /**
             *  @var array
             */
            $this->data = $data;
    }

    /**
     *  @param  string $key
     *  @param  mixed  $alt
     *
     *  @return \Blu\Http\Cookie
     */
    public function get($key, $alt = null)
    {
        return new File(
            $key, parent::get($key, $alt)
        );
    }
}
