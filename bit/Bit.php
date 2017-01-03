<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Data;

/**
 * @subpackage Bit
 */
class Bit implements BitInterface
{
    /**
     *  @var array
     */
    protected $maps = [];

    /**
     *  @var array
     */
    protected $mask  = 0;

    /**
     *  @return mixed
     */
    public function __construct($mask, array $maps = null)
    {
        /**
         *  @var integer
         */
        $this->mask = $mask;

        /**
         *  @var array
         */
        $maps = $maps === null ?
            $this->maps : $maps;

        /**
         *  @var Data
         */
        $this->maps = new Data();

        /**
         *  @var bool
         */
        if (sizeof($maps) === 0)
            return;

        /**
         *  @var integer
         */
        $index = 1;

        /**
         *  @var iterable
         */
        foreach ($maps as $name) {
            /**
             *  @var integer
             */
            $this->maps->set(
                $name, $index
            );

            /**
             *  @var integer
             */
            $index += $index;
        }
    }

    public function get($bit)
    {
        /**
         *  @var bool
         */
        return boolval(
            $this->mask & $this->maps->get(
                $bit, $bit
            )
        );
    }

    /**
     *  @param integer $bit
     *  @param integer $value
     */
    public function set($bit, $value)
    {
        $bit  = $this->maps->get(
            $bit, $bit
        );

        /**
         *  @var bool
         */
        $isset = $this->get($bit);

        /**
         *  @var integer
         */
        $value = boolval($value);

        /**
         *  @var bool
         */
        if ($isset && !$value)
            $this->mask -= $bit;

        /**
         *  @var bool
         */
        if (!$isset && $value)
            $this->mask += $bit;

        /**
         *  @var $this
         */
        return $this;
    }

    public function mask($mask = null)
    {
        /**
         *  @var bool
         */
        if ($mask === null)
            /**
             *  @var integer
             */
            return $this->mask;

        /**
         *  @var bool
         */
        if ($mask !== '*') {
            /**
             *  @var integer
             */
            $this->mask = $mask;

            /**
             *  @var $this
             */
            return $this;
        }

        /**
         *  @var integer
         */
        $this->mask = $this->bit('*');

        /**
         *  @var $this
         */
        return $this;
    }

    public function bit($bits)
    {
        /**
         *  @var bool
         */
        if ($bits === '*')
            /**
             *  @var array
             */
            $bits = array_values(
                $this->maps->data()
            );

        /**
         *  @var bool
         */
        if (gettype($bits) !== 'array')
            /**
             *  @var array
             */
            $bits = func_get_args();

        /**
         *  @var integer
         */
        $mask = 0;

        /**
         *  @var iterable
         */
        foreach ($bits as $bit)
            /**
             *  @var integer
             */
            $mask += $this->maps->get(
                $bit, $bit
            );

        /**
         *  @var integer
         */
        return $mask;
    }

    /**
     *  @param  scalar $bit
     *
     *  @return bool
     */
    public function __get($bit)
    {
        return $this->get($bit);
    }

    /**
     *  @param  scalar $bit
     *
     *  @return bool
     */
    public function __set($bit, $value)
    {
        return $this->set($bit, $value);
    }

    /**
     *  @param  scalar $bit
     *
     *  @return bool
     */
    public function __isset($bit)
    {
        return $this->get($bit);
    }
}
