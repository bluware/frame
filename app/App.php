<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\App\Exception;

/**
 * @subpackage App
 */
class App
{
    use Locator\Support;

    /**
     *  @var array
     */
    protected static $singleton;

    /**
     *  App constructor.
     *
     *  @param array $config
     */
    public function __construct($config = [])
    {
        /**
         *  @var \Frame\Locator
         */
        $locator = new Locator();

        /**
         *  @var \Frame\App
         */
        $locator->add($this, 'app');

        /**
         *  @var \Frame\Locator
         */
        $locator->add(
            $locator, 'locator'
        );

        /**
         *
         */
        $config = new Config(
            $config
        );

        /**
         *  @var \Frame\Locator
         */
        $locator->add($config, 'config');

        /**
         *  @var boolean
         */
        if ($config->get('procedures', true) === true)
            /**
             *  @var void
             */
            include_once(
                __DIR__ . '/../procedures.php'
            );

        /**
         *  @var \Frame\Locator
         */
        $autoload = new Autoload();

        /**
         *  @var \Frame\Locator
         */
        $locator->add($autoload, 'autoload');

        /**
         *
         */
        $this->extract($config, 'autoload', [
            $autoload, 'add'
        ]);

        /**
         *
         */
        $mediator = new Mediator($locator);

        /**
         *
         */
        $locator->add($mediator, 'mediator');

        /**
         *
         */
        $request = new Request();

        /**
         *
         */
        $locator->add($request, 'request');

        /**
         *
         */
        $routing = new Routing($request);

        /**
         *
         */
        $locator->add($routing, 'router');

        /**
         *
         */
        $i18n = new I18n(
            $request->locale()
        );

        /**
         *
         */
        $locator->add($i18n, 'translator');

        /**
         *  @var \Frame\View
         */
        $view = new View();

        /**
         *  @var \Frame\View
         */
        $locator->add($view, 'view');

        /**
         *  @var \Frame\Database\Union
         */
        $redis = Redis\Manager::singleton();

        /**
         *  @var \Frame\Database\Union
         */
        $locator->add($redis, 'redis');

        /**
         *  @var void
         */
        $this->extract($config, 'redis', [
            $redis, 'add'
        ]);

        /**
         *  @var \Frame\Database\Union
         */
        $database = Database::union();

        /**
         *  @var \Frame\Database\Union
         */
        $locator->add($database, 'database');

        /**
         *  @var void
         */
        $this->extract($config, 'database', [
            $database, 'add'
        ]);

        /**
         *
         */
        $secure = Secure::chain();

        /**
        *
        */
        $locator->add($secure, 'secure');

        /**
         *
         */
        $locator->add(new Hook, 'hook');

        /**
         *  @var void
         */
        $this->extract($config, 'secure', [
            $secure, 'set'
        ]);

        /**
         *
         */
        $this->locator = $locator;

        /**
         *  @var $this
         */
        static::$singleton = $this;

        /**
         *  @var $this
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
         *  @var boolean
         */
        $isset = $config->has($key);

        /**
         *  @var boolean
         */
        if ($isset === false)
            return $this;

        /**
         *  @var mixed
         */
        $config = $config->get($key);

        /**
         *  @var boolean
         */
        if (gettype($config) !== 'array')
            $config = ['default' => $config];

        /**
         *  @var boolean
         */
        foreach ($config as $key => $value)
            call_user_func(
                $call, $key, $value
            );

        /**
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
        array $packages     = null,
        array $directories  = null
    ) {
        /**
         *  @var \Frame\Package\Dispatcher
         */
        $package = new Package\Dispatcher(
            $packages, $directories
        );

        /**
         *  @var void
         */
        $this->locator()->add($package, 'package');

        /**
         *  @var void
         */
        $package->dispatch(
            $this
        );

        /**
         *  @var $this
         */
        return $this;
    }

    public function run()
    {
        ob_start();
        // ob_start("ob_gzhandler");

        echo $this->locator->get(
            'router'
        )->dispatch(
            $this
        );

        ob_end_flush();
    }

    public function __get($key)
    {
        return $this->{$key};
    }

    public static function singleton($input = null)
    {
        $app = static::$singleton;

        if ($input === null)
            return $app;

        $var = func_get_args();

        return call_user_func_array([
            $app, array_shift($var)
        ], $var);
    }

    /**
     *  @param \Frame\App|null $instance
     *
     *  @return \Frame\App|null
     *  @throws Exception
     */
    public static function instance(App $instance = null)
    {
        /**
         *  @var App|null
         */
        static $app = null;

        if ($instance === null) {
            if ($app === null)
                throw new Exception(
                    "App construction cannot be empty"
                );

            return $app;
        }


        /**
         *  @var bool
         */
        if ($app !== null)
            throw new Exception(
                "App construction cannot be reinitialize"
            );

        /**
         *  @var bool
         */
        if ($app === null)
            $app = $instance;

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
     *  @return mixed
     *  @throws Exception
     */
    public static function factory($classname)
    {
        if (is_subclass_of($classname, Entry::class) === false)
            throw new Exception(
                "App factory cannot create instance from non-child of Frame\\Entry"
            );

        return new $classname(
            static::instance()
        );
    }
}
