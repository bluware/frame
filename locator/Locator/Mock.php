<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Locator;

/**
 * @subpackage Locator
 */
trait Mock
{
    /**
     *  @var \Frame\Locator
     */
    protected $locator;

    /**
     *  Fast locator implementation.
     *
     *  @return mixed
     */
    public function locator($input = null)
    {
        /**
         *  @var bool
         */
        if ($this->locator === null)
            /**
             *  @var \Frame\Exception
             */
            throw new Exception(
                'Locator is null and cannot executed.'
            );

        /**
         *  @var bool
         */
        if ($input === null)
            /**
             *  @var bool
             */
            return $this->locator;

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
            $this->locator, $method
        ], $params);
    }
}