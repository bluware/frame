<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Request;

use Frame\Http\Exception;
use Frame\Request;

trait Support
{
    /**
     *  @var \Frame\Request
     */
    protected $request;

    /**
     *  @param null $input
     *
     *  @throws Exception
     *
     *  @return Request|mixed
     */
    public function request($input = null)
    {
        /*
         *  @var bool
         */
        if ($this->request === null) {
            /*
             *  @var boolean
             */
            if (property_exists($this, 'service') === false) {
                /*
                 *  @thrown Exception
                 */
                throw new Exception(
                    'Request is null and cannot executed.'
                );
            }

            $this->request = $this->getService(
                Request::class
            );
        }

        /*
         *  @var bool
         */
        if ($input === null) {
            /*
             *  @var bool
             */
            return $this->request;
        }

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

        /*
         *  @var mixed
         */
        return call_user_func_array([
            $this->request, $method,
        ], $params);
    }
}
