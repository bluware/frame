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
     *  @var boolean
     */
    protected $secure   = false;

    /**
     *  @param mixed $data
     */
    public function __construct(array $data = null, $secure = false)
    {
        if ($data !== null)
            /**
             *  @var array
             */
            $this->data = $data;

        /**
         *  @var boolean
         */
        $this->secure = $secure;
    }

    /**
     *  @param  string $key
     *  @param  mixed  $alt
     *
     *  @return \Blu\Http\Cookie
     */
    public function get($key, $alt = null)
    {
        return new Cookie(
            $key,
            parent::get(
                $key, $alt
            ),
            0,
            '',
            '',
            $this->secure
        );
    }
}
