<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Service;

use Frame\Data;
use Frame\Data\Readable;

/**
 * @subpackage Service
 */
class Locator extends Readable
{
    /**
     * @var \Frame\Data
     */
    protected $services;

    /**
     *  @param mixed $data
     *
     *  @return void
     */
    public function __construct($data = null)
    {
        $this->services = new Data();

        if ($data !== null)
            $this->data = $data;
    }

    /**
     *  @param  mixed   $service
     *  @param  string  $alias
     *
     *  @return void
     */
    public function add($service, $alias)
    {
        /**
         *  @var string
         */
        $interface = is_object($service) ?
            get_class($service) : $alias;

        /**
         *  @var mixed
         */
        $this->data[$interface] = $service;

        /**
         *  @var string
         */
        $this->services->set($alias, $interface);

        return $this;
    }

    /**
     *  @param  string  $key
     *
     *  @return boolean
     */
    public function has($key)
    {
        return parent::has($key) === false ?
            $this->services->has($key) : true;
    }

    /**
     *  @param  string  $key
     *  @param  mixed   $alternate
     *
     *  @return mixed
     */
    public function get($key, $alternate = null)
    {
        $service = parent::get($key, $alternate);

        if ($service === null)
            $service = parent::get(
                $this->services->get(
                    $key, $alternate
                )
            );

        return $service;
    }
}
