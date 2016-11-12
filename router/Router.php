<?php

/**
 *  Blu | PHP Lite Web & API Framework
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

/**
 * @subpackage Router
 */
class Router extends RouterAbstract
{
    /**
     *  @param  string $pattern
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function any($pattern, $handler = null, $priority = 0)
    {
        return $this->add(
            [
                'GET', 'POST', 'PUT', 'DELETE'
            ],
            $pattern,
            $handler,
            $priority
        );
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function get($pattern, $handler = null, $priority = 0)
    {
        return $this->add(
            [
                'GET'
            ],
            $pattern,
            $handler,
            $priority
        );
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function post($pattern, $handler = null, $priority = 0)
    {
        return $this->add(
            [
                'POST'
            ],
            $pattern,
            $handler
        );
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function put($pattern, $handler = null, $priority = 0)
    {
        return $this->add(
            [
                'PUT'
            ],
            $pattern,
            $handler
        );
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function delete($pattern, $handler = null, $priority = 0)
    {
        return $this->add(
            [
                'DELETE'
            ], $pattern,
            $handler
        );
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function del($pattern, $handler = null, $priority = 0)
    {
        return $this->delete(
            $pattern,
            $handler
        );
    }

    /**
     *  @param  string $pattern
     *  @param  mixed  $handler
     *
     *  @return void
     */
    public function cli($pattern, $handler = null, $priority = 0)
    {
        return $this->add([
                'CLI'
            ],
            $pattern,
            $handler,
            $priority
        );
    }

    /**
     *  @param array  $methods
     *  @param scalar $pattern
     *  @param mixed  $handler
     *
     *  @return void
     */
    public function deny($pattern, $handler = null, $priority = 0)
    {
        return $this->any(
            $pattern,
            $handler,
            $priority + 49
        );
    }
}
