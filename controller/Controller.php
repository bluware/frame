<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Http;
use Frame\App;

/**
 * @subpackage Controller
 */
abstract class Controller
{
    protected $app;

    protected $request;

    /**
     *
     */
    public function __construct(App $app)
    {
        $this->app      = $app;

        $this->request  = $app->locator()->get('request');
    }

    /**
     *  Fast router implementation.
     *
     *  @return mixed
     */
    function request($input = null)
    {
        if ($input === null)
            return $this->request;

        $params = func_get_args();

        return call_user_func([
            $this->request, array_shift(
                $params
            )
        ], $params);
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
