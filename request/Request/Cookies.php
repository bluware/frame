<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Request;

use Frame\Data\Readable;
use Frame\Cookie;

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
     * Cookies constructor.
     * @param array|null $data
     * @param bool $secure
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
     * @param $key
     * @param null $alt
     * @return Cookie
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
