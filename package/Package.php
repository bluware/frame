<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\App;
use Frame\Locator;
use Frame\Hook;

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
     *  @return void
     */
    final public function __construct(App $app)
    {
        /**
         *  @var Frame\App
         */
        $this->app      = $app;

        /**
         *  @var Frame\Locator
         */
        $this->locator  = $app->locator();

        /**
         *  @var Frame\App
         */
        method_exists($this, 'bootstrap') ?
            $this->bootstrap(
                $app->locator()
            ) : null;

        method_exists($this, 'autoload') ?
            $this->autoload(
                $app->locator('get', 'autoload')
            ) : null;

        method_exists($this, 'hook') ?
            $this->hook(
                $app->locator('get', 'hook')
            ) : null;

        method_exists($this, 'routing') ?
            $this->routing(
                $app->locator('get', 'router')
            ) : null;

        method_exists($this, 'view') ?
            $this->view(
                $app->locator('get', 'view')
            ) : null;
    }
}
