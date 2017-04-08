<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Redis;

use Frame\Data\Readable;
use Frame\Data;
use Redis;

/**
 * @subpackage Redis
 */
class Manager extends Readable
{
    protected function __construct()
    {
        //
    }

    protected function configure(array $config)
    {
        $data   = new Data($config);

        $redis  = new Redis();

        $success = $data->equal(
            'type', 'socket'
        ) ? $redis->connect(
            $data->get(
                'path', '/tmp/redis.sock'
            )
        ) : $redis->connect(
            $data->get(
                'host', '127.0.0.1'
            ), $data->get(
                'post', 6379
            )
        );

        if ($data->get('strict', true) === true && $success === false)
            throw new Exception(
                sprintf(
                    "Cannot connect to %s:%s", $data->get(
                        'host', '127.0.0.1'
                    ), $data->get(
                        'post', 6379
                    )
                )
            );

        $prefix = $data->get('prefix', null);

        if ($prefix !== null) {
            $redis->setOption(
                Redis::OPT_PREFIX,
                substr($prefix, -1) !== ':' ?
                    sprintf('%s:', $prefix) : $prefix
            );
        }

        $data->get('prefix', null);

        return $redis;
    }

    public function add($name = 'default', $instance)
    {
        if ($this->has($name) === true)
            throw new Exception(
                sprintf("Connection '%s' exists", $name)
            );

        return $this->set(
            $name, $instance
        );
    }

    public function set($name = 'default', $instance)
    {
        switch (gettype($instance)) {
            case 'array':
                $instance = $this->configure(
                    $instance
                );
                break;

            case 'object':
                if ($instance instanceof Redis === false)
                    throw new Exception(
                        'Bad connection instance. Should be \Redis instance.'
                    );
                break;

            default:
                throw new Exception(
                    'Bad connection instance. Should be \Redis instance.'
                );
                break;
        }

        $this->data[$name] = $instance;

        return $this;
    }

    public static function singleton()
    {
        static $instance = null;

        if ($instance === null)
            $instance = new static();

        return $instance;
    }
}
