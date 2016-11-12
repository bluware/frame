<?php


/**
 *  Fast router implementation.
 *
 *  @return mixed
 */
function http($method)
{
    $params = func_get_args();

    if (
        in_array($method, [
            'request',
            'router',
            'response',
            'client'
        ], true)
    ) {
        return forward_static_call_array([
            'Blu\Http', array_shift($params)
        ], $params);
    }

    if (
        in_array($method, [
            'cookie',
            'server',
            'files',
            'query',
            'post',
            'put',
            'delete',
        ], true)
    ) {
        return forward_static_call_array([
            'Blu\Http', 'request'
        ], $params);
    }

    if (
        in_array($method, [
            'html',
            'text',
            'json',
            'xml',
            'view'
        ], true)
    ) {
        return forward_static_call_array([
            'Blu\Response',
            array_unshift($params),
        ], $params);
    }
}

/**
 *  Fast router implementation.
 *
 *  @return mixed
 */
function client($method)
{
    $params = func_get_args();

    if (
        $method !== null
        && in_array(
            $method, [
                'get',
                'post',
                'put',
                'delete',
                'del'
            ], true
        )
    ) {
        return call_user_func_array([
            'Blu\Client',
            array_shift($params)
        ], $params);
    }

    return new \Blu\Client(
        $method
    );
}

/**
 *  Fast router implementation.
 *
 *  @return mixed
 */
function rest($method)
{
    $params = func_get_args();

    if (
        $method !== null
        && in_array(
            $method, [
                'get',
                'post',
                'put',
                'delete',
                'del'
            ], true
        )
    ) {
        return call_user_func_array([
            'Blu\Client',
            array_shift($params)
        ], $params);
    }

    return new \Blu\Client(
        $method
    );
}

/**
 *  Fast router implementation.
 *
 *  @return mixed
 */
function router($method = null)
{
    if ($method === null)
        return http('router');

    $params = func_get_args();

    return call_user_func_array([
        http('router'),
        array_shift($params)
    ], $params);
}

/**
 *  Fast router implementation.
 *
 *  @return mixed
 */
function request($method = null)
{
    if ($method === null)
        return http('request');

    $params = func_get_args();

    return call_user_func_array([
        http('request'),
        array_shift($params)
    ], $params);
}

/**
 *  Fast router implementation.
 *
 *  @return mixed
 */
function response($method)
{
    $params = func_get_args();

    if (
        in_array($method, [
            'html',
            'text',
            'json',
            'xml',
            'view'
        ], true)
    ) {
        return forward_static_call_array([
            'Blu\Response',
            array_unshift($params),
        ], $params);
    }

    return call_user_func_array([
        'Blu\Response',
        '__construct'
    ], $params);
}


/**
 *  Fast router implementation.
 *
 *  @return mixed
 */
function cookie($method = null)
{
    $params = func_get_args();

    return call_user_func_array([
        http('request'), 'cookie',
    ], $params);
}

/**
 *  Fast router implementation.
 *
 *  @return mixed
 */
function server($method = null)
{
    $params = func_get_args();

    return call_user_func_array([
        http('request'), 'server'
    ], $params);
}
