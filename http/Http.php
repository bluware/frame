<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Http
 */
class Http implements HttpInterface
{
    /**
     * @param null $method
     * @return Request|mixed|null
     */
    public static function request($method = null)
    {
        /**
         * @var void
         */
        static $request = null;

        /**
         * @var boolean
         */
        if ($request === null)
            /**
             * @var \Frame\Request
             */
            $request = new Request();

        /**
         * @var boolean
         */
        if ($method === null)
            /**
             * @var \Frame\Request
             */
            return $request;

        /**
         * @var array
         */
        $params = func_get_args();

        /**
         * @var mixed
         */
        return call_user_func_array([
            $request,
            array_shift($params)
        ], $params);
    }

    /**
     *  @param  string $input
     *
     *  @return mixed
     */
    public static function cookie($input = null, $alt = null)
    {
        /**
         * @var void
         */
        $request = static::request();

        /**
         * @var boolean
         */
        if ($input === null)
            /**
             * @var \Frame\Request
             */
            return $request->cookie();

        /**
         * @var mixed
         */
        return $request->cookie(
            $input, $alt
        );
    }

    /**
     * @param $body
     * @param int $code
     * @param array $headers
     * @return Response|mixed
     */
    public static function response(
        $body, $code = 200, $headers = []
    ) {
        /**
         *  @var if
         */
        if (
            in_array($body, [
                'text',
                'html',
                'xml',
                'json',
                'redirect',
                'goto'
            ], true)
        ) {
            /**
             *  @var array
             */
            $params = func_get_args();

            /**
             *  @var array
             */
            return forward_static_call_array([
                Response::class,
                array_shift($params)
            ], $params);
        }

        /**
         *  @var Response
         */
        return new Response(
            $body, $code, $headers
        );
    }
}
