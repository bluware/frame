<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\Redis\Manager;

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
        return Manager::singleton()->get(static::$adapter);
    }
}
