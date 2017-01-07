<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\App;
use Frame\AppTrait;
use Frame\Http;
use Frame\ViewTrait;
use Frame\Http\RequestTrait;
use Frame\Http\ResponseTrait;
use Frame\Service\LocatorTrait;

/**
 * @subpackage Controller
 */
abstract class Controller
{
    use AppTrait, LocatorTrait, RequestTrait, ResponseTrait, ViewTrait;

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
        $this->locator  = $this->app('locator');

        /**
         *  @var \Frame\Http\Request
         */
        $this->request  = $this->app(
            'locator', 'get', 'request'
        );
    }
}
