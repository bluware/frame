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
class Router extends RouterAbstract
{
    /**
     *  @param  string $route
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function any($route, $handler)
    {
        return $this->add([
            'GET', 'POST', 'PUT', 'DELETE', 'OPTION'
        ], $route, $handler);
    }

    /**
     *  @param  string $route
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function get($route, $handler)
    {
        return $this->add([
            'GET'
        ], $route, $handler);
    }

    /**
     *  @param  string $route
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function post($route, $handler)
    {
        return $this->add([
            'POST'
        ], $route, $handler);
    }

    /**
     *  @param  string $route
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function put($route, $handler)
    {
        return $this->add([
            'PUT'
        ], $route, $handler);
    }

    /**
     *  @param  string $route
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function delete($route, $handler)
    {
        return $this->add([
            'DELETE'
        ], $route, $handler);
    }

    /**
     *  @param  string $route
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function del($route, $handler)
    {
        return $this->delete(
            $route, $handler
        );
    }

    /**
     *  @param  string $route
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function option($route, $handler)
    {
        return $this->add([
            'OPTION'
        ], $route, $handler);
    }
}