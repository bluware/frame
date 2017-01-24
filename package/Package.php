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
         *  @var bool
         */
        if (method_exists($this, 'translator') === true) {
            /**
             *  @var Frame\I18n
             */
            $i18n = $app->locator('get', 'translator');

            /**
             *  @var array
             */
            $directories = $this->translator($i18n);

            /**
             *  @var array
             */
            if (gettype($directories) === 'array')
                /**
                 *  @var iterable
                 */
                foreach ($directories as $directory)
                    /**
                     *  @var Frame\Hook\Controller
                     */
                    $i18n->scan($directory);
        }

        /**
         *  @var mixed
         */
        method_exists($this, 'autoload') ?
            $this->autoload(
                $app->locator('get', 'autoload')
            ) : null;

        /**
         *  @var Frame\App
         */
        method_exists($this, 'bootstrap') ?
            $this->bootstrap(
                $app->locator()
            ) : null;

        /**
         *  @var bool
         */
        if (method_exists($this, 'hook') === true) {
            /**
             *  @var array
             */
            $controllers = $this->hook(
                $app->locator('get', 'hook')
            );

            /**
             *  @var array
             */
            if (gettype($controllers) === 'array')
                /**
                 *  @var iterable
                 */
                foreach ($controllers as $controller)
                    /**
                     *  @var Frame\Hook\Controller
                     */
                    new $controller($app);
        }

        /**
         *  @var mixed
         */
        method_exists($this, 'routing') ?
            $this->routing(
                $app->locator('get', 'router')
            ) : null;

        /**
         *  @var mixed
         */
        method_exists($this, 'view') ?
            $this->view(
                $app->locator('get', 'view')
            ) : null;
    }
}
