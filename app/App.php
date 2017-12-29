<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\App\Exception;

class App
{
    use TServiceProvider;

    /**
     *  @var array
     */
    protected static $singleton;

    /**
     * @var bool
     */
    protected $report = true;

    /**
     * @var bool
     */
    protected $appcache = false;

    /**
     *  App constructor.
     *
     *  @param array $config
     */
    public function __construct($applicationConfigurationPath)
    {
        $config = new Config(
            $applicationConfigurationPath
        );

        new Environment($config, $applicationConfigurationPath);

        $this->appcache = $config->pull(
            'cache.application', false
        );

        /**
         *  @var \Frame\ServiceLocator
         */
        $locator = new ServiceLocator();

        /*
         *  @var \Frame\App
         */
        $locator->addService($this, 'app');

        /*
         *  @var \Frame\Locator
         */
        $locator->addService($locator, 'service');

        /*
         *  @var \Frame\Locator
         */
        $locator->addService($config, 'config');

        /*
         *  @var boolean
         */
        if ($config->get('procedures', true) === true) {
            /**
             *  @var void
             */
            include_once __DIR__.'/../procedures.php';
        }

        /**
         *  @var \Frame\ServiceLocator
         */
        $autoload = new Autoload();

//        if ($this->appcache === true) {
//            $autoload->cacheImport(
//                $config->pull('cache.autoload', null)
//            );
//        }

        /*
         *  @var \Frame\Locator
         */
        $locator->addService($autoload, 'autoload');

        /*
         *
         */
        $this->extract($config, 'autoload', [
            $autoload, 'add',
        ]);

        $mediator = new Mediator($locator);

        /*
         *
         */
        $locator->addService($mediator, 'mediator');

        $request = new Request();

        /*
         *
         */
        $locator->addService($request, 'request');

        $routing = new Routing($request);

        /*
         *
         */
        $locator->addService($routing, 'router');

        $i18n = new I18n(
            $request->locale()
        );

        /*
         *
         */
        $locator->addService($i18n, 'translator');

        /**
         *  @var \Frame\View
         */
        $view = new View();

        /*
         *  @var \Frame\View
         */
        $locator->addService($view, 'view');

        /**
         *  @var \Frame\Database\Union
         */
        $redis = Redis\Manager::singleton();

        /*
         *  @var \Frame\Database\Union
         */
        $locator->addService($redis, 'redis');

        /*
         *  @var void
         */
        $this->extract($config, 'redis', [
            $redis, 'add',
        ]);

        /**
         *  @var \Frame\Database\Union
         */
        $database = Database\Manager::singleton();

        /*
         *  @var \Frame\Database\Union
         */
        $locator->addService($database, 'database');

        /*
         *  @var void
         */
        $this->extract($config, 'database', [
            $database, 'add',
        ]);

        $secure = Secure::chain();

        /*
        *
        */
        $locator->addService($secure, 'secure');

        /*
         *
         */
        $locator->addService(new Hook(), 'hook');

        /*
         *  @var void
         */
        $this->extract($config, 'secure', [
            $secure, 'set',
        ]);

        /*
         *
         */
        $this->setServiceLocator($locator);

        /**
         *  @var
         */
        static::$singleton = $this;

        /**
         *  @var
         */
        static::instance($this);
    }

    /**
     *  @param \Frame\Data $config
     *  @param $key
     *  @param callable $call
     *
     *  @return $this
     */
    protected function extract(Config $config, $key, callable $call)
    {
        /**
         *  @var bool
         */
        $isset = $config->has($key);

        /*
         *  @var boolean
         */
        if ($isset === false) {
            return $this;
        }

        /**
         *  @var mixed
         */
        $config = $config->get($key);

        /*
         *  @var boolean
         */
        if (gettype($config) !== 'array') {
            $config = ['default' => $config];
        }

        /*
         *  @var boolean
         */
        foreach ($config as $key => $value) {
            call_user_func(
                $call, $key, $value
            );
        }

        /*
         *  @var boolean
         */
        return $this;
    }

    /**
     *  @param array|null $packages
     *  @param array|null $directories
     *
     *  @return $this
     */
    public function package(
        array $packages = null,
        array $directories = null
    ) {
        /**
         *  @var \Frame\Package\Dispatcher
         */
        $package = new Package\Dispatcher(
            $packages, $directories
        );

        $config = $this->getService('config');

        if ($this->appcache === true) {
            $package->cacheImport(
                $config->pull('cache.package', null)
            );
        }

        /*
         *  @var void
         */
        $this->getServiceLocator()->addService($package, 'package');

        /*
         *  @var void
         */
        $package->dispatch(
            $this
        );

        /*
         *  @var $this
         */
        return $this;
    }

    public function run()
    {
        ob_start();
        // ob_start("ob_gzhandler");

        $response = $this->getServiceLocator()->getService(
            'router'
        )->dispatch(
            $this
        );

        echo $response;

        ob_end_flush();

        $config = $this->getService('config');

        if ($this->appcache === true) {
            $this->getService('autoload')->cacheExport(
                $config->pull('cache.autoload', null)
            );

            $this->getService('package')->cacheExport(
                $config->pull('cache.package', null)
            );
        }
    }

    public function __get($key)
    {
        return $this->{$key};
    }

    public static function singleton($input = null)
    {
        $app = static::$singleton;

        if ($input === null) {
            return $app;
        }

        $var = func_get_args();

        return call_user_func_array([
            $app, array_shift($var),
        ], $var);
    }

    /**
     * @param App|null $instance
     * @return App
     * @throws Exception
     */
    public static function instance(App $instance = null): App
    {
        /**
         *  @var App|null
         */
        static $app = null;

        if ($instance === null) {
            if ($app === null) {
                throw new Exception(
                    'App construction cannot be empty'
                );
            }

            return $app;
        }

        /*
         *  @var bool
         */
        if ($app !== null) {
            throw new Exception(
                'App construction cannot be reinitialize'
            );
        }

        /*
         *  @var bool
         */
        if ($app === null) {
            $app = $instance;
        }

        return $app;
    }

    public function daemon($name = null, $time = 1)
    {
        $daemon = new Daemon(
            $this
        );

        $daemon->name(
            $name
        )->time(
            $time
        );

        return $daemon;
    }

    /**
     *  @param $classname
     *
     *  @throws Exception
     *
     *  @return mixed
     */
    public static function factory($classname)
    {
        if (is_subclass_of($classname, Entry::class) === false) {
            throw new Exception(
                'App factory cannot create instance from non-child of Frame\\Entry'
            );
        }

        return new $classname(
            static::instance()
        );
    }
}
