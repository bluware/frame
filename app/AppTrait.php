<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage App
 */
trait AppTrait
{
    /**
     *  @var \Frame\Service\Locator
     */
    protected $app;

    /**
     *  Fast locator implementation.
     *
     *  @return mixed
     */
    public function app($input = null)
    {
        /**
         *  @var bool
         */
        if ($this->app === null)
            /**
             *  @var \Frame\Service\Exception
             */
            throw new Exception(
                'App is null and cannot executed.'
            );

        /**
         *  @var bool
         */
        if ($input === null)
            /**
             *  @var bool
             */
            return $this->app;

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
            $this->app, $method
        ], $params);
    }
}
