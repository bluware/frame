<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame\Http
 *  @author   Eugen Melnychenko
 */
namespace Frame\Request;

use Frame\Http\Exception;
use Frame\Request;

/**
 * @subpackage Request
 */
trait Support
{
    /**
     *  @var \Frame\Request
     */
    protected $request;

    /**
     *  @param null $input
     *
     *  @return Request|mixed
     *  @throws Exception
     */
    public function request($input = null)
    {
        /**
         *  @var bool
         */
        if ($this->request === null) {
            /**
             *  @var boolean
             */
            if (property_exists($this, 'locator') === false)
                /**
                 *  @thrown Exception
                 */
                throw new Exception(
                    'Request is null and cannot executed.'
                );

            $this->request = $this->locator(
                Request::class
            );
        }

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
