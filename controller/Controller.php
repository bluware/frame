<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\App;
use Frame\Hook;
use Frame\Locator;
use Frame\Http\Request;
use Frame\Http\Response;
use Frame\View;

/**
 * @subpackage Controller
 */
abstract class Controller
{
    use App\Mock, Locator\Mock, Hook\Mock, Request\Mock, Response\Mock, View\Mock;

    public function __construct(App $app)
    {
        $this->app      = $app;

        $this->locator  = $app->locator();

        $this->request  = $app->locator(
            'get', 'request'
        );

        $this->hook  = $app->locator(
            'get', 'hook'
        );
    }
}
