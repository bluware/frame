<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *  
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Http;

/**
 * @subpackage Http
 */
class Response extends ResponseAbstract
{
    /**
     * @param  scalar   $body
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return \Blu\Http\Response
     */
    public static function text($body, $code = 200, array $headers = [])
    {
        return new static(
            $body, $code, array_replace($headers, [
                'Content-Type' => 'text/plain; charset=utf-8'
            ])
        );
    }

    /**
     * @param  scalar   $body
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return \Blu\Http\Response
     */
    public static function html($body, $code = 200, array $headers = [])
    {
        return new static(
            $body, $code, array_replace($headers, [
                'Content-Type' => 'text/html; charset=utf-8'
            ])
        );
    }

    /**
     * @param  mixed    $body
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return \Blu\Http\Response
     */
    public static function json($body, $code = 200, array $headers = [])
    {
        return new static(
            json_encode($body, JSON_PRETTY_PRINT),
            $code,
            array_replace($headers, [
                'Content-Type' => 'application/json; charset=utf-8'
            ])
        );
    }

    /**
     * @param  scalar   $body
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return \Blu\Http\Response
     */
    public static function xml($body, $code = 200, array $headers = [])
    {
        return new static(
            $body, $code, array_replace($headers, [
                'Content-Type' => 'application/xml; charset=utf-8'
            ])
        );
    }

    /**
     * @param  scalar   $url
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return \Blu\Http\Response
     */
    public static function redirect($url, $code = 303, array $headers = [])
    {
        return new static(
            null, $code, array_replace($headers, [
                'Location' => $url
            ])
        );
    }
}
