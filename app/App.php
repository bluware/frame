<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Package;
use Frame\Autoload;
use Frame\Locator;
use Frame\Database;
use Frame\Http;
use Frame\Routing;
use Frame\Http\Request;
use Frame\Secure;
use Frame\View;
use Frame\Hook;
use Frame\Data;
use Frame\I18n;
use Frame\App;
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
     *  @return void
     */
    public function __construct($config = [])
    {
        /**
         *  @var \Frame\Locator
         */
        $locator = new Locator();

        /**
         *  @var array
         */
        $config = new Data(
            gettype($config) === 'string' && is_file($config) ?
                include($config) : $config
        );

        /**
         *  @var Frame\Service\Locator
         */
        $locator->add($config, 'config');

        /**
         *  @var Frame\Service\Locator
         */
        $autoload = new Autoload();

        /**
         *  @var Frame\Service\Locator
         */
        $locator->add($autoload, 'autoload');

        /**
         *
         */
        $this->extract($config, 'autoload', [
            $autoload, 'add'
        ]);

        /**
         *  @var \Frame\Request
         */
        $request = new Request();

        /**
         *  @var \Frame\Request
         */
        $locator->add($request, 'request');

        /**
         *  @var \Frame\Router
         */
        $routing = new Routing();

        /**
         *  @var \Frame\Router
         */
        $locator->add($routing, 'router');

        /**
         *  @var \Frame\Router
         */
        $i18n = new I18n(
            $request->locale()
        );

        /**
         *  @var \Frame\Router
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
         *  @var \Frame\Secure\Keychain
         */
        $secure = Secure::chain();

        /**
         *  @var \Frame\Secure\Keychain
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
         *  @var \Frame\Service\Locator
         */
        $this->locator = $locator;

        /**
         *  @var $this
         */
        static::$singleton = $this;

        /**
         *  @var $this
         */
        static::app($this);
    }

    /**
     *  @param  array    $config [description]
     *  @param  [type]   $key    [description]
     *  @param  callable $call   [description]
     *
     *  @return [type]           [description]
     */
    protected function extract(Data $config, $key, callable $call)
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
         *  @var \Frame\App\Package
         */
        $package = new Package\Dispatcher(
            $packages, $directories
        );

        /**
         *  @var \Frame\App\Package
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
        )->compile(
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
    public static function app(App $instance = null)
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

    /**
     *  @param $classname
     *
     *  @return mixed
     *  @throws Exception
     */
    public static function factory($classname)
    {
        if (is_subclass_of($classname, Node::class) === false)
            throw new Exception(
                "App factory cannot create instance from non-child of Frame\\Node"
            );

        return new $classname(
            static::app()
        );
    }
}
