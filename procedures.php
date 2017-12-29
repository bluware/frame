<?php

use Frame\App;

/**
 * @return App|null
 * @throws App\Exception
 */
function app()
{
    return App::instance();
}

function locator(string $serviceName = null)
{
    if (!is_null($serviceName)) {
        return App::instance()->getService($serviceName);
    }

    return App::instance()->getServiceLocator();
}

function service(string $serviceName)
{
    return App::instance()->getService($serviceName);
}

function serviceLocator()
{
    return App::instance()->getServiceLocator();
}

function autoload($namespace, $path)
{
    return service('autoload')->add($namespace, $path);
}

function request()
{
    return service('request');
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
    $page = app()->getService('view')->make(
        $path, $data, $prevent
    );

    /*
     *  @var \Frame\Response
     */
    return Frame\Response::html(
        $page, $code, $headers
    );
}

function response($body, $code = 200, $headers = [])
{
    /*
     *  @var mixed
     */
    return forward_static_call_array(
        [
            Frame\Http::class,
            'response',
        ], func_get_args()
    );
}

function redirect($url, $code = 200, array $headers = [])
{
    /*
     *  @var \Frame\Response
     */
    return response(
        'redirect', $url, $code, $headers
    );
}

function __($word, $locale = null)
{
    return service('translator')->translate(
        $word, $locale
    );
}

function route($method, $route, $handler, $separator = '@')
{
    return call_user_func([
        service('router'), $method,
    ], $route, $handler);
}

function routes($method, array $data)
{
    return call_user_func([
        service('router'), $method,
    ], $data);
}

function routing(array $group = null, callable $calle = null)
{
    if ($group === null) {
        return service('router');
    }

    return service('router')->group(
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
