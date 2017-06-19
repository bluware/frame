<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\Memcache\Manager;

abstract class Memcache
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
