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

function request()
{
    return locator('request');
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
    return Frame\Http\Response::html(
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

function route($class, $event, $separator = '@')
{
    return sprintf(
        '%s%s%s', $class, $event, $separator
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
