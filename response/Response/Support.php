<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Response;

use Frame\Http;
use Frame\Response;

trait Support
{
    /**
     *  @param  string $input
     *
     *  @return mixed
     */
    public function response($body, $code = 200, $headers = [])
    {
        /*
         *  @var mixed
         */
        return forward_static_call_array(
            [
                Http::class,
                'response',
            ], func_get_args()
        );
    }

    /**
     * @param $body
     * @param int $code
     * @param array $headers
     * @return Response
     */
    public function jsonResponse($body, $code = 200, $headers = [])
    {
        return Response::json($body, $code, $headers);
    }

    /**
     * @param $body
     * @param int $code
     * @param array $headers
     * @return Response
     */
    public function textResponse($body, $code = 200, $headers = [])
    {
        return Response::text($body, $code, $headers);
    }

    /**
     * @param $body
     * @param int $code
     * @param array $headers
     * @return Response
     */
    public function xmlResponse($body, $code = 200, $headers = [])
    {
        return Response::xml($body, $code, $headers);
    }

    /**
     * @param $body
     * @param int $code
     * @param array $headers
     * @return Response
     */
    public function htmlResponse($body, $code = 200, $headers = [])
    {
        return Response::html($body, $code, $headers);
    }

    /**
     *  @param  string      $url
     *  @param  int     $code
     *  @param  array       $headers
     *
     *  @return mixed
     */
    public function redirect($url, $code = 200, array $headers = [])
    {
        /*
         *  @var \Frame\Response
         */
        return $this->response(
            'redirect', $url, $code, $headers
        );
    }

    /**
     *  @param  string      $url
     *  @param  int     $code
     *  @param  array       $headers
     *
     *  @return mixed
     */
    public function goto($url, $code = 200, array $headers = [])
    {
        /*
         *  @var \Frame\Response
         */
        return $this->response(
            'redirect', $url, $code, $headers
        );
    }
}
