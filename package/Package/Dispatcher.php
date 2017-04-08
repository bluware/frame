<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Package;

use Frame\App;
use Frame\Data;

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
     * Dispatcher constructor.
     *
     * @param array|null $packages
     * @param array|null $directories
     */
    public function __construct(
        array $packages = null,
        array $directories = null
    ) {
        /*
         *  @var array
         */
        $this->packages = new Data($packages);

        /*
         *  @var array
         */
        $this->directories = new Data($directories);
    }

    /**
     * @param array|null $packages
     * @param array|null $directories
     */
    public function add(
        array $packages = null,
        array $directories = null
    ) {
        /*
         *  @var array
         */
        $this->packages->replace($packages);

        /*
         *  @var array
         */
        $this->directories->replace($directories);
    }

    public function exists($name)
    {
        return in_array(
            $name, array_values(
                $this->packages
            ), true
        );
    }

    /**
     * @param App $app
     */
    public function dispatch(App $app)
    {
        $packages = [];

        foreach ($this->packages as $path => $namespace) {
            $directory = null;

            if (is_numeric($path) === true) {
                $path = str_replace('\\', '/', $namespace);
            }

            $package = sprintf('%s\\Package', $namespace);

            class_exists($package) === false ?
                $this->browse($path, $directory) : null;

            $instance = new $package($app);

            $app->locator('autoload')->add(
                $namespace, $directory
            );

            /*
             *  @var bool
             */
            if (method_exists($instance, 'translator') === true) {
                /**
                 *  @var Frame\I18n
                 */
                $i18n = $app->locator('translator');

                /**
                 *  @var array
                 */
                $directories = $instance->translator($i18n);

                /*
                 *  @var array
                 */
                if (gettype($directories) === 'array') {
                    /*
                     *  @var iterable
                     */
                    foreach ($directories as $directory) {
                        /*
                         *  @var Frame\Hook\Controller
                         */
                        $i18n->scan($directory);
                    }
                }
            }

            /*
             *  @var mixed
             */
            method_exists($instance, 'autoload') ?
                $instance->autoload(
                    $app->locator('autoload')
                ) : null;

            $packages[] = $instance;
        }

        /*
         *  Second phase of booting
         */
        foreach ($packages as $package) {
            /*
             *  @var Frame\App
             */
            method_exists($package, 'bootstrap') ?
                $package->bootstrap(
                    $app->locator()
                ) : null;

            /*
             *  @var bool
             */
            if (method_exists($package, 'hook') === true) {
                /**
                 *  @var array
                 */
                $controllers = $package->hook(
                    $app->locator('hook')
                );

                /*
                 *  @var array
                 */
                if (gettype($controllers) === 'array') {
                    /*
                     *  @var iterable
                     */
                    foreach ($controllers as $controller) {
                        /*
                         *  @var Frame\Hook\Controller
                         */
                        new $controller($app);
                    }
                }
            }

            /*
             *  @var mixed
             */
            method_exists($package, 'routing') ?
                $package->routing(
                    $app->locator('router')
                ) : null;

            /*
             *  @var mixed
             */
            method_exists($package, 'view') ?
                $package->view(
                    $app->locator('view')
                ) : null;
        }
    }

    protected function __namespace($class)
    {
        $path = explode(
            '\\', $class
        );

        return array_pop(
            $class
        );
    }

    /**
     *  @return void
     */
    public function browse($path, &$_directory)
    {
        foreach ($this->directories as $directory) {
            $directory = sprintf(
                '%s/%s', $directory, $path
            );

            $file = sprintf(
                '%s/Package.php', $directory
            );

            if (is_file($file) === true) {
                include_once $file;

                $_directory = $directory;

                return;
            }
        }
    }
}
