<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Hook;

use Frame\Hook\Exception;

/**
 * @subpackage Hook
 */
trait Mock
{
    /**
     *  @var \Frame\Hook
     */
    protected $hook;

    /**
     *  Fast locator implementation.
     *
     *  @return mixed
     */
    public function hook($input = null)
    {
        /**
         *  @var bool
         */
        if ($this->hook === null)
            /**
             *  @var \Frame\Service\Exception
             */
            throw new Exception(
                'Hook is null and cannot executed.'
            );

        /**
         *  @var bool
         */
        if ($input === null)
            /**
             *  @var bool
             */
            return $this->hook;

        /**
         *  @var array
         */
        $params = func_get_args();

        /**
         *  @var string
         */
        $method = array_shift(
            $params
        );

        /**
         *  @var mixed
         */
        return call_user_func_array([
            $this->hook, $method
        ], $params);
    }
}
