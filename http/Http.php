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
    public static function router()
    {
        static $router = null;

        if ($router === null)
            $router = new \Blu\Http\Router();

        return $router;
    }

    /**
     *  @param  string $input
     *
     *  @return mixed
     */
    public static function request($input = null)
    {
        static $request = null;

        if ($request === null)
            $request = new \Blu\Http\Request();

        if ($input !== null)
            return call_user_func([$request, $input]);

        return $request;
    }

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
     *  @param  mixed $data
     *
     *  @return Blu\Essence\Response
     */
    public static function response(
        $body, $status = 200, array $headers = []
    ) {
        return new \Blu\Http\Response($body, $status, $headers);
    }
}