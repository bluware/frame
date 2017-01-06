<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\App;
use Frame\Http;

use Frame\Service\LocatorTrait;

/**
 * @subpackage Controller
 */
abstract class Controller
{
    use Http\RequestTrait;

    use LocatorTrait;

    /**
     *  @var \Frame\App
     */
    protected $app;

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
