<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Service\Autoload;
use Frame\Service\Locator;
use Frame\Database;
use Frame\Http;
use Frame\Router;
use Frame\Request;
use Frame\Secure;

/**
 * @subpackage App
 */
class App
{
    protected $locator;

    public function __construct()
    {
        /**
         *  @var Frame\Service\Locator
         */
        $locator = new Locator();

        /**
         *  @var Frame\Service\Locator
         */
        $locator->add(
            new Autoload(),
            'autoload'
        );

        /**
         *  @var \Frame\Request
         */
        $locator->add(
            Http::request(),
            'request'
        );

        /**
         *  @var \Frame\Router
         */
        $locator->add(
            new Router(),
            'router'
        );

        /**
         *  @var \Frame\Database\Union
         */
        $locator->add(
            Database::union(),
            'database'
        );

        /**
         *  @var \Frame\Secure\Keychain
         */
        $locator->add(
            Secure::keychain(),
            'keychain'
        );

        $this->locator = $locator;
    }

    public static function http($instance)
    {
        /**
         *  @var array
         */
        $params = func_get_args();

        /**
         *  @var array
         */
        return forward_static_call_array([
            Http::class,
            array_shift($params)
        ], $params);
    }
}
