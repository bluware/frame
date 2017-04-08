<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\Data\Readable;
use Frame\Locator\Exception;

class Locator extends Readable
{
    /**
     * @var \Frame\Data
     */
    protected $invokable;

    /**
     *  Locator constructor.
     */
    public function __construct()
    {
        $this->invokable = new Data();
    }

    /**
     *  @param $service
     *  @param null $alias
     *
     *  @throws Exception
     *
     *  @return $this
     */
    public function add($service, $alias = null)
    {
        /*
         *  @var string
         */
        if (gettype($service) !== 'object' && $alias === null) {
            throw new Exception(
                'Non-object service should have alias name'
            );
        }

        $interface = gettype($service) === 'object' ?
            get_class($service) : $alias;

        /*
         *  @var mixed
         */
        $this->data[$interface] = $service;

        /*
         *  @var boolean
         */
        if ($alias !== null) {
            /*
             *  @var string
             */
            $this->invokable->set($alias, $interface);
        }

        return $this;
    }

    /**
     *  @param string $key
     *
     *  @return bool
     */
    public function has($key)
    {
        if (parent::has($key) === true) {
            return true;
        }

        return $this->invokable->has($key);
    }

    /**
     *  @param string $key
     *  @param null $alt
     *
     *  @return mixed
     */
    public function get($key, $alt = null)
    {
        $instance = parent::get($key, $alt);

        if ($instance === null) {
            $key = $this->invokable->get($key, $alt);

            $instance = parent::get($key, $alt);
        }

        if (is_callable($instance) === true) {
            $instance = call_user_func($instance, $this);

            $this->data[$key] = $instance;
        }

        return $instance;
    }
}
