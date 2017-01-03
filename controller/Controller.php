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
    /**
     *  @var \Frame\App
     */
    protected $app;

    /**
     *  @var \Frame\Http\Request
     */
    protected $request;

    /**
     *  @var \Frame\Service\Locator
     */
    protected $locator;

    /**
     *
     */
    public function __construct(App $app)
    {
        /**
         *  @var \Frame\App
         */
        $this->app      = $app;

        /**
         *  @var \Frame\App
         */
        $this->locator  = $app->locator();

        /**
         *  @var \Frame\Http\Request
         */
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

        return call_user_func_array([
            $this->request, array_shift(
                $params
            )
        ], $params);
    }

    /**
     *  Fast router implementation.
     *
     *  @return mixed
     */
    function locator($input = null)
    {
        if ($input === null)
            return $this->locator;

        $params = func_get_args();

        return call_user_func_array([
            $this->locator, array_shift(
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

    /**
     *  @param  string      $path
     *  @param  array       $data
     *  @param  boolean     $prevent
     *  @param  integer     $code
     *  @param  array       $headers
     *
     *  @return mixed
     */
    public function view(
        $path, array $data = [], $prevent = false, $code = 200, $headers = []
    ) {
        /**
         *  @var mixed
         */
        $page = $this->locator->get('view')->make(
            $path, $data, $prevent
        );

        /**
         *  @var \Frame\Response
         */
        return $this->response(
            'html', $page, $code, $headers
        );
    }

    /**
     *  @param  string      $url
     *  @param  integer     $code
     *  @param  array       $headers
     *
     *  @return mixed
     */
    public function redirect($url, $code = 200, array $headers = [])
    {
        /**
         *  @var \Frame\Response
         */
        return $this->response(
            'redirect', $url, $code, $headers
        );
    }

    /**
     *  @param  string      $url
     *  @param  integer     $code
     *  @param  array       $headers
     *
     *  @return mixed
     */
    public function goto($url, $code = 200, array $headers = [])
    {
        /**
         *  @var \Frame\Response
         */
        return $this->response(
            'redirect', $url, $code, $headers
        );
    }
}
