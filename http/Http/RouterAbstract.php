<?php

/**
 *  Blu | PHP Lite Web & API Framework
 *  
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Http;

/**
 * @subpackage Http
 */
abstract class RouterAbstract
{
    /**
     *  @var string
     */
    protected $separator    = ':';

    /**
     *  @var string
     */
    protected $capture      = '[a-zA-Z0-9\$\-\_\.\+\!\*\'\(\)]+';

    /**
     *  @var \Blu\Http\Router\Routes
     */
    protected $routes;

    /**
     *  # comment ...
     */
    public function __construct()
    {
        $this->routes = new \Blu\Http\Router\Routes();
    }

    /**
     *  Hot method for access to property.
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function routes($input = null, $alternate = null)
    {
        if ($input === null)
            return $this->routes;

        return $this->routes->get(
            $input, $alternate
        );
    }

    /**
     *  @param array  $methods
     *  @param scalar $route
     *  @param mixed  $handler
     */
    public function add(array $methods, $route, $handler)
    {
        if (
            in_array(
                $_SERVER['REQUEST_METHOD'], $methods, true
            ) === true
        ) {
            $this->routes->set(
                uniqid(
                    rand(100000,999999)
                ), compact(
                    'route', 'handler'
                )
            );
        }

        return $this;
    }

    /**
     *  @param \Blu\Http\RequestAbstract
     */
    public function run(\Blu\Http\RequestAbstract $request)
    {
        foreach ($this->routes as $block) {
            extract($block);

            if (
                preg_match(
                    $this->patternize($route),
                    $_SERVER['REQUEST_URI'], // url
                    $params
                )
            ) {
                $this->filtrate($params);

                return $this->make(
                    $handler, $params
                );
            }
        }

        return new \Blu\Http\Response(
            "@blu 404", 404
        );
    }

    /**
     *  @param array  $methods
     *  @param scalar $route
     *  @param mixed  $handler
     */
    public function make($handler, $params)
    {
        if (is_callable($handler) === true)
            return call_user_func_array(
                $handler, $params
            );

        list($class, $method) = explode(
            $this->separator, $handler
        );

        return call_user_func_array([
            new $class(), $method
        ], $params);
    }

    protected function filtrate(&$params)
    {
        array_shift($params);

        foreach ($params as $key => $param)
            if ($param === null && $param === "")
                unset($params[$key]);
    }

    /**
     *  @param \Blu\Http\RequestAbstract
     */
    protected function patternize($route)
    {
        $xor = str_replace([
            '/',  '[',  ']', '*'
        ], [
            '\/', '(|', ')', '.*?'
        ], $route);

        $all = preg_replace(
            '/\:[a-zA-Z0-9\_\-]+/',
            sprintf(
                '(%s)', $this->capture
            ),
            $xor
        );

        return sprintf('/^%s$/', $all);
    }
}
