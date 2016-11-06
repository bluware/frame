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
interface HttpInterface
{
    /**
     *  @param  string $url
     *
     *  @return Blu\Http\Client
     */
    public static function client($url);

    /**
     *  @return Blu\Http\Router
     */
    public static function router();

    /**
     *  @param  string $data
     *
     *  @return Blu\Http\Request
     */
    public static function request(
        $input = null
    );

    /**
     *  @param  mixed $data
     *
     *  @return Blu\Http\Response
     */
    public static function response(
        $data,
        $status         = 200,
        array $headers  = null
    );
}
