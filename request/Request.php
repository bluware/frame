<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Request
 */
class Request extends RequestAbstract implements RequestInterface
{
    /**
     *  @return \Blu\Request
     */
    public static function singleton()
    {
        static $instance = null;

        if ($instance === null)
            $instance = new static();

        return $instance;
    }
}
