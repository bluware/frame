<?php

use Frame\App;

function app()
{
    return App::instance();
}

function locator($invokable = null)
{
    return app()->locator($invokable);
}

function autoload($namespace, $path)
{
    return locator('autoload')->add($namespace, $path);
}

function request()
{
    return locator('request');
}

function daemon($name = null, $time = 0)
{
    return app()->daemon($name, $time);
}

function view($path, array $data = [], $prevent = false, $code = 200, $headers = [])
{
    /**
     *  @var mixed
     */
    $page = app()->locator('view')->make(
        $path, $data, $prevent
    );

    /**
     *  @var \Frame\Response
     */
    return Frame\Response::html(
        $page, $code, $headers
    );
}

function response($body, $code = 200, $headers = [])
{
    /**
     *  @var mixed
     */
    return forward_static_call_array(
        [
            Frame\Http::class,
            'response'
        ], func_get_args()
    );
}

function redirect($url, $code = 200, array $headers = [])
{
    /**
     *  @var \Frame\Response
     */
    return response(
        'redirect', $url, $code, $headers
    );
}

function __($word, $locale = null)
{
    return locator('translator')->translate(
        $word, $locale
    );
}

function route($method, $route, $handler, $separator = '@')
{
    return call_user_func([
        locator('router'), $method
    ], $route, $handler);
}

function routes($method, array $data)
{
    return call_user_func([
        locator('router'), $method
    ], $data);
}

function routing(array $group = null, callable $calle = null)
{
    if ($group === null)
        return locator('router');

    return locator('router')->group(
        $group, $calle
    );
}

function base($path = '')
{
    return sprintf(
        '%s%s', $_SERVER['DOCUMENT_ROOT'], $path
    );
}

// include 'http/procedures.php';
// include __DIR__ . '/package/procedures.php';
// include __DIR__ . '/service/#procedure.php';
