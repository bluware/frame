<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

/**
 * @subpackage Http
 */
class Http implements HttpInterface
{
    /**
     *  @param  string $input
     *
     *  @return mixed
     */
    public static function uri($url)
    {
        return new \Blu\Http\URI($url);
    }

    /**
     *  @param  string $data
     *
     *  @return Blu\Http\Client
     */
    public static function client($url)
    {
        return new \Blu\Http\Client($url);
    }

    /**
     *  @param  string $data
     *
     *  @return Blu\Http\Router
     */
    public static function router($method = null)
    {
        static $router = null;

        if ($router === null)
            $router = new \Blu\Router(
                \Blu\Http::request()
            );

        if ($method === null)
            return $router;

        $params = func_get_args();

        return call_user_func_array([
            $router,
            array_shift($params)
        ], $params);
    }

    /**
     *  @param  string $input
     *
     *  @return mixed
     */
    public static function request($method = null)
    {
        static $request = null;

        if ($request === null)
            $request = new \Blu\Request();

        if ($method === null)
            return $request;

        $params = func_get_args();

        return call_user_func_array([
            $request,
            array_shift($params)
        ], $params);
    }

    /**
     *  @param  mixed $data
     *
     *  @return Blu\Essence\Response
     */
    public static function response(
        $body, $status = 200, array $headers = []
    ) {
        return new \Blu\Response($body, $status, $headers);
    }
}
