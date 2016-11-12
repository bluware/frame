<?php

/**
 *  Blu | PHP Lite Web & API Framework
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

use Blu\RequestInterface;

use Blu\Router\Aspects;
use Blu\Router\Groups;
use Blu\Router\Routes;
use Blu\Controller;

/**
 * @subpackage Router
 */
abstract class RouterAbstract
{
    /**
     *  @var string
     */
    protected $separator    = '@';

    /**
     *  @var string
     */
    protected $capture      = '[a-zA-Z0-9\$\-\_\.\+\!\*\'\(\)]+';

    /**
     *  @var \Blu\RequestAbstract
     */
    protected $request;

    /**
     *  @var  Router\Guardians
     */
    protected $guardians;

    /**
     *  @var Router\Controllers
     */
    protected $controllers;

    /**
     *  @var Router\Routes
     */
    protected $routes;

    /**
     *  @var Router\Routes
     */
    protected $denies;

    /**
     *  # comment ...
     */
    public function __construct(
        RequestInterface $request,
        $separator = '@'
    ) {
        /**
         * @var string
         */
        $this->separator    = $separator;

        /**
         *  @var Router\Routes
         */
        $this->routes       = new Routes();

        /**
         *  @var Router\Routes
         */
        $this->denies       = new Routes();

        /**
         *  @var \Blu\RequestAbstract
         */
        $this->request      = $request;

        /**
         *  @var Router\Guardians
         */
        $this->aspects    = new Aspects();

        /**
         *  @var Router\Guardians
         */
        $this->groups       = new Groups();
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
     *  Hot method for access to property.
     *
     *  @param  scalar $input
     *  @param  mixed  $alternate
     *
     *  @return mixed
     */
    public function aspect($aspect, $class = null)
    {
        if ($aspects === null)
            return null;

        $aspects = is_array($aspect) ?
            $aspect : [$aspect => $class];

        return $this->aspects
            ->replace(
                $aspects
            );
    }

    /**
     *  @param array  $methods
     *  @param scalar $route
     *  @param mixed  $handler
     *
     *  @return void
     */
    public function add(array $methods, $route, $handler = null)
    {
        if (
            $this->request->method('in', $methods)
        ) {
            $routes = is_array($route) ? $route : [
                $route => $handler
            ];

            foreach ($routes as $route => $handler) {
                $this->routes->set(
                    uniqid(
                        rand(100000,999999)
                    ), compact(
                        'route', 'handler'
                    )
                );
            }
        }

        return $this;
    }

    /**
     *  @param array  $methods
     *  @param scalar $route
     *  @param mixed  $handler
     *
     *  @return void
     */
    public function deny($route, $handler = null)
    {
        $routes = is_array($route) ? $route : [
            $route => $handler
        ];

        foreach ($routes as $route => $handler) {
            $this->denies->set(
                $route, compact(
                    'route', 'handler'
                )
            );
        }

        return $this;
    }

    /**
     *  @param \Blu\RequestAbstract
     */
    public function run()
    {
        $matches = $this->iterate(
            $this->routes
        );

        if ($matches !== null)
            return $matches;

        $matches = $this->iterate(
            $this->denies, ['*']
        );

        if ($matches !== null)
            return $matches;

        return $this->iterate(
            $this->denies->get('*')
        );
    }

    /**
     *  @param array  $methods
     *  @param scalar $route
     *  @param mixed  $handler
     */
    protected function iterate($iterable, array $ignore = [])
    {
        if ($iterable === null)
            return null;

        if (is_array($iterable) === true) {
            $iterable = [$iterable];
        }

        $uri = $this->request->uri();

        foreach ($iterable as $item) {
            if (
                !in_array(
                    $item['route'],
                    $ignore, true
                ) && preg_match(
                    $this->pattern(
                        $item['route']
                    ),
                    $uri, // url
                    $params
                )
            ) {
                $reponded = $this->make(
                    $item['handler'],
                    $this->filter($params),
                    $control
                );

                if (
                    $control === null || !is_subclass_of(
                        $control, Controller::class
                    ) && !$control->passed()
                ) {
                    return $reponded;
                }
            }
        }

        return null;
    }

    /**
     *  @param array  $methods
     *  @param scalar $route
     *  @param mixed  $handler
     */
    protected function make($handler, $params, &$class)
    {
        if (is_callable($handler) === true)
            return call_user_func_array(
                $handler, $params
            );

        list($class, $method) = explode(
            $this->separator, $handler
        );

        $class = new $class();

        return call_user_func_array([
            $class, $method
        ], $params);
    }

    /**
     *  @param  array $params
     *
     *  @return [type]
     */
    protected function filter(&$params)
    {
        array_shift($params);

        foreach ($params as $key => $param)
            if ($param === null && $param === "")
                unset($params[$key]);

        return $params;
    }

    /**
     *  @param string
     */
    protected function pattern($route)
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
