<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\App, Frame\Locator;

/**
 * @subpackage Package
 */
abstract class Package
{
    /**
     *  @trait Frame\App\Mock
     */
    use App\Mock, Locator\Mock;
    
    /**
     *  Package constructor.
     *
     *  @param \Frame\App $app
     */
    final public function __construct(App $app)
    {
        /**
         *  @var \Frame\App
         */
        $this->app      = $app;

        /**
         *  @var \Frame\Locator
         */
        $this->locator  = $app->locator();
    }
}
