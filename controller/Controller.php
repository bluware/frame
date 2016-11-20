<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Http;

/**
 * @subpackage Controller
 */
abstract class Controller implements ControllerInterface
{
    /**
     *  @var boolean
     */
    protected $pass = false;

    /**
     *  @return void
     */
    public function prevent()
    {
        $this->pass = false;

        return $this;
    }

    /**
     *  @return void
     */
    public function next()
    {
        $this->pass = true;

        return $this;
    }

    /**
     *  Fast router implementation.
     *
     *  @return mixed
     */
    function request($input = null)
    {
        /**
         *  @var mixed
         */
        return forward_static_call_array(
            [
                Http::class,
                'request'
            ], func_get_args()
        );
    }

    /**
     *  @param  string $input
     *
     *  @return mixed
     */
    public function response($body, $code = 200, $headers = []) {
        /**
         *  @var mixed
         */
        return forward_static_call_array(
            [
                Http::class,
                'response'
            ], func_get_args()
        );
    }
}
