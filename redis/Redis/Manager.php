<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Redis;

use Frame\Data;
use Redis;

/**
 * @subpackage Redis
 */
class Manager
{
    /**
     *  @var string
     */
    protected $adapters;

    /**
     * Manager constructor.
     */
    protected function __construct()
    {
        $this->adapters = new Data();
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

        return $redis;
    }

    public function add($name = 'default', $instance)
    {
        if ($this->adapters->has($name) === true)
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

        $this->adapters->set(
            $name, $instance
        );

        return $this;
    }

    public function get($name = 'default')
    {
        return $this->adapters->get(
            $name, null
        );
    }

    public static function singleton()
    {
        static $instance = null;

        if ($instance === null)
            $instance = new static();

        return $instance;
    }
}
