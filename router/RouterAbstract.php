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
use Blu\Router\Routes\Route;
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
     *  @var \Blu\RequestInterface
     */
    protected $request;

    /**
     *  @var  \Blu\Router\Aspects
     */
    protected $aspects;

    /**
     *  @var \Blu\Router\Invokes
     */
    protected $groups;

    /**
     *  @var \Blu\Router\Routes
     */
    protected $routes;

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
         *  @var \Blu\RequestAbstract
         */
        $this->request      = $request;

        /**
         *  @var \Blu\Router\Aspects
         */
        $this->aspects      = new Aspects();

        /**
         *  @var \Blu\Router\Groups
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
        $mind = $this->groups->to('array');

        $this->groups->from('array', $group);

        call_user_func($call, $this);

        $this->groups->from('array', $mind);

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
     *  @param \Blu\RequestAbstract
     */
    public function run()
    {
        $request = $this->request;
        $routes  = $this->routes();

        if ($request->is('cli') === true) {
            if ($request->server('argc') < 2)
                return '#bad_cli_request';

            $argv = $request->server('argv');

            array_shift($argv);
        }

        $pattern = $request->is('cli') ?
            join(' ', $argv) : $request->uri();

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
