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
        $this->app      = $app;

        $this->locator  = $app->locator();

        method_exists($this, 'bootstrap') ?
            $this->bootstrap(
                $app->locator()
            ) : null;

        method_exists($this, 'autoload') ?
            $this->autoload(
                $app->locator()->get('autoload')
            ) : null;

        method_exists($this, 'routing') ?
            $this->routing(
                $app->locator()->get('router')
            ) : null;

        method_exists($this, 'view') ?
            $this->view(
                $app->locator()->get('view')
            ) : null;
    }
}
