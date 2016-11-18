<?php

/**
 *  Blu | PHP Lite Web & API Framework
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

/**
 * @subpackage Service
 */
class Service implements ServiceInterface
{
    /**
     *  @param  mixed $method
     *
     *  @return Blu\Service\Autoload
     */
     public static function autoload($method = null)
    {
        static $autoload = null;

        if ($autoload === null)
            $autoload = (
                new \Blu\Service\Autoload()
            )->register();

        if ($method === null)
            return $autoload;

        $params = func_get_args();

        return call_user_func_array([
            $autoload,
            array_shift($params)
        ], $params);
    }

    /**
     *  @param  mixed $method
     *
     *  @return Blu\Service\Autoload
     */
     public static function locator($method = null)
    {
        static $locator = null;

        if ($locator === null)
            $locator = new \Blu\Service\Locator();

        if ($method === null)
            return $locator;

        $params = func_get_args();

        return call_user_func_array([
            $locator,
            array_shift($params)
        ], $params);
    }
}
