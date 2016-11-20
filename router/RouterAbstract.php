<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\RequestInterface;
use Frame\Router\Aspects;
use Frame\Router\Groups;
use Frame\Router\Routes;
use Frame\Router\Routes\Route;
use Frame\Controller;

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
     *  @var \Frame\RequestInterface
     */
    protected $request;

    /**
     *  @var  \Frame\Router\Aspects
     */
    protected $aspects;

    /**
     *  @var \Frame\Router\Invokes
     */
    protected $groups;

    /**
     *  @var \Frame\Router\Routes
     */
    protected $routes;

    /**
     *  # comment ...
     */
    public function __construct(
        RequestInterface $request, $separator = '@'
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
         *  @var \Frame\RequestAbstract
         */
        $this->request      = $request;

        /**
         *  @var \Frame\Router\Aspects
         */
        $this->aspects      = new Aspects();

        /**
         *  @var \Frame\Router\Groups
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
    public function aspect($aspect, $call = null)
    {
        return $this->aspects->replace(
                is_array($aspect) ?
                    $aspect : [$aspect => $class]
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
    public function group($group, callable $call)
    {
        $mind = $this->groups->data();

        $this->groups->change($group);

        call_user_func($call, $this);

        $this->groups->revert($mind);

        return $this;
    }

    /**
     *  @param array  $methods
     *  @param scalar $route
     *  @param mixed  $handler
     *
     *  @return void
     */
    public function add($method, $pattern, $handler = null, $priority = 0)
    {
        /**
         *  @var array
         */
        $methods = is_array($method) ? $method : [$method];

        if ($this->request->method('in', $methods) === false)
            return $this;

        /**
         *  @var array
         */
        $patterns = is_array($pattern) ? $pattern : [
            $pattern => $handler
        ];

        /**
         *  @var integer
         */
        $priority = is_numeric($handler) ?
            $handler : $priority;

        $groups = $this->groups;

        /**
         *  @var void
         */
        foreach ($patterns as $pattern => $handler) {
            $this->routes->push(
                new Route(
                    $pattern,
                    $handler,
                    $groups->get(
                        'aspects',
                        []
                    ),
                    $groups->get(
                        'namespace',
                        ''
                    )
                ), $pattern === '*' ?
                    99 : $priority
            );
        }

        return $this;
    }

    /**
     *  @param \Frame\RequestAbstract
     */
    public function run()
    {
        $request = $this->request;
        $routes  = $this->routes()->sort();

        if ($request->is('cli') === true) {
            if ($request->server('argc') < 2)
                return '#bad_cli_request';

            $argv = $request->server('argv');

            array_shift($argv);
        }

        $pattern = $request->is('cli') ?
            join(' ', $argv) : $request->path();

        foreach ($routes as $route) {
            if ($route->match($pattern, $matches) === true) {
                $response = $route->eval(
                    $this->aspects,
                    $this->separator,
                    $matches, $pass
                );

                if ($pass === false)
                    return $response;
            }
        }

        return '#not_found';
    }
}
