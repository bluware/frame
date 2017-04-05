<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Redis\Manager;

/**
 * @subpackage Redis
 */
abstract class Redis
{
    /**
     *  @var string
     */
    protected static $adapter = 'default';

    /**
     *  @return mixed|null
     */
    protected static function adapter()
    {
        return Manager::singleton()->get(
            static::$adapter
        );
    }
}
