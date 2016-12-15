<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\App\Packages;
use Frame\Service\Autoload;
use Frame\Service\Locator;
use Frame\Database;
use Frame\Http;
use Frame\Routing;
use Frame\Http\Request;
use Frame\Secure;
use Frame\View;

/**
 * @subpackage App
 */
class App
{
    /**
     *  @var Frame\Service\Locator
     */
    protected $locator;

    /**
     *  @return void
     */
    public function __construct($config = [])
    {
        /**
         *  @var Frame\Service\Locator
         */
        $locator = new Locator();

        /**
         *  @var array
         */
        $config = gettype($config) === 'string' && is_file($config) ?
            include($config) : $config;

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
        $secure = Secure::keychain();

        /**
         *  @var \Frame\Secure\Keychain
         */
        $locator->add($secure, 'secure');

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
    }

    public function locator()
    {
        return $this->locator;
    }

    /**
     *  @param  array    $config [description]
     *  @param  [type]   $key    [description]
     *  @param  callable $call   [description]
     *
     *  @return [type]           [description]
     */
    protected function extract(array $config, $key, callable $call)
    {
        /**
         *  @var boolean
         */
        $isset = array_key_exists($key, $config);

        /**
         *  @var boolean
         */
        if ($isset === false)
            return $this;

        /**
         *  @var mixed
         */
        $config = $config[$key];

        /**
         *  @var boolean
         */
        if (gettype($config) !== 'array')
            $config = ['default' => $config];

        /**
         *  @var boolean
         */
        foreach ($config as $key => $value) {
             call_user_func($call, $key, $value);
        }

        /**
         *  @var boolean
         */
        return $this;
    }

    /**
     *  @param  array $packages
     *  @param  array $directories
     *
     *  @return void
     */
    public function package(
        array $packages     = null,
        array $directories  = null
    ) {
        /**
         *  @var \Frame\App\Package
         */
        $package = new Packages(
            $packages, $directories
        );

        /**
         *  @var \Frame\App\Package
         */
        $this->locator->add(
            $package, 'package'
        );

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
}
