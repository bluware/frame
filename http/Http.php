<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Request;
use Frame\Response;

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
     *  @param  mixed $data
     *
     *  @return Frame\Essence\Response
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
         *  @var Blu\Essence\Response
         */
        return new Response(
            $body, $code, $headers
        );
    }
}
