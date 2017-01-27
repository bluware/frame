<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Package;

use Frame\Data;
use Frame\App;

/**
 * @subpackage Package
 */
class Dispatcher
{
    /**
     *  @var \Frame\Data\Readable
     */
    protected $directories;

    /**
     *  @var \Frame\Data\Readable
     */
    protected $packages;

    /**
     *  @return void
     */
    public function __construct(
        array $packages     = null,
        array $directories  = null
    ) {
        /**
         *  @var array
         */
        $this->packages     = new Data($packages);

        /**
         *  @var array
         */
        $this->directories  = new Data($directories);
    }

    /**
     *  @return void
     */
    public function add(
        array $packages     = null,
        array $directories  = null
    ) {
        /**
         *  @var array
         */
        $this->packages->replace($packages);

        /**
         *  @var array
         */
        $this->directories->replace($directories);
    }

    /**
     *  @return void
     */
    public function dispatch(App $app)
    {
        $packages = [];

        foreach ($this->packages as $path => $namespace) {
            if (is_numeric($path) === true)
                $path = str_replace('\\', '/', $namespace);

            $package = sprintf('%s\\Package', $namespace);

            class_exists($package) === false ?
                $this->browse($path) : null;

            $package = new $package($app);

            /**
             *  @var bool
             */
            if (method_exists($package, 'translator') === true) {
                /**
                 *  @var Frame\I18n
                 */
                $i18n = $app->locator('get', 'translator');

                /**
                 *  @var array
                 */
                $directories = $package->translator($i18n);

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
            method_exists($package, 'autoload') ?
                $package->autoload(
                    $app->locator('get', 'autoload')
                ) : null;

            $packages[] = $package;
        }

        /**
         *  Second phase of booting
         */
        foreach ($packages as $package) {
            /**
             *  @var Frame\App
             */
            method_exists($package, 'bootstrap') ?
                $package->bootstrap(
                    $app->locator()
                ) : null;

            /**
             *  @var bool
             */
            if (method_exists($package, 'hook') === true) {
                /**
                 *  @var array
                 */
                $controllers = $package->hook(
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
            method_exists($package, 'routing') ?
                $package->routing(
                    $app->locator('get', 'router')
                ) : null;

            /**
             *  @var mixed
             */
            method_exists($package, 'view') ?
                $package->view(
                    $app->locator('get', 'view')
                ) : null;
        }
    }

    /**
     *  @return void
     */
    public function browse($path)
    {
        foreach ($this->directories as $directory) {
            $file = sprintf(
                '%s/%s/Package.php',
                $directory,
                $path
            );

            is_file($file) ?
                include($file) : null;
        }
    }
}
