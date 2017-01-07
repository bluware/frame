<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame\Http
 *  @author   Eugen Melnychenko
 */
namespace Frame\Http\Request;

use Frame\Http\Exception;

/**
 * @subpackage Request
 */
trait Mock
{
    /**
     *  @var \Frame\Service\Locator
     */
    protected $request;

    /**
     *  Fast locator implementation.
     *
     *  @return mixed
     */
    public function request($input = null)
    {
        /**
         *  @var bool
         */
        if ($this->request === null)
            /**
             *  @var \Frame\Service\Exception
             */
            throw new Exception(
                'Request is null and cannot executed.'
            );

        /**
         *  @var bool
         */
        if ($input === null)
            /**
             *  @var bool
             */
            return $this->request;

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
            $this->request, $method
        ], $params);
    }
}
