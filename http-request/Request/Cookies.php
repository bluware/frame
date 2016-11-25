<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Http\Request;

use Frame\Data\Readable;
use Frame\Http\Cookie;

/**
 * @subpackage Request
 */
class Cookies extends Readable
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
     *  @param  mixed  $alternate
     *
     *  @return \Blu\Http\Cookie
     */
    public function get($key, $alternate = null)
    {
        return new Cookie(
            $key, parent::get($key, $alternate)
        );
    }
}
