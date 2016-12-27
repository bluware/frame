<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Redis
 */
class Redis implements RedisInterface
{
    /**
     *  @var string
     */
    protected $adapter;

    public function bit($key, $value = null)
    {
        if ($value === null)
            return $this->adapter('get', 'bit', $key);
    }

    /**
     *  @return [type] [description]
     */
    public function adapter($event = null)
    {
        $adapter = $this->adapter;

        if ($event === null)
            return $adapter;
    }

    public static function command($command, $argv)
    {
        $this->adapter()->{$command};
    }
}
