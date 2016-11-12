<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

/**
 * @subpackage Client
 */
class Client extends ClientAbstract
{
    /**
     *  @param string   $url
     *
     *  @return \Blu\Client
     */
    public static function get($url)
    {
        return (
            new static($url)
        )->method(
            'get'
        );
    }

    /**
     *  @param string   $url
     *  @param string   $body
     *
     *  @return \Blu\Client
     */
    public static function post($url, $body = '')
    {
        return (
            new static($url)
        )->method(
            'post'
        )->body(
            $body
        );
    }

    /**
     *  @param string   $url
     *  @param string   $body
     *
     *  @return \Blu\Client
     */
    public static function put($url, $body = '')
    {
        return (
            new static($url)
        )->method(
            'put'
        )->body(
            $body
        );
    }

    /**
     *  @param string   $url
     *  @param string   $body
     *
     *  @return \Blu\Client
     */
    public static function delete($url, $body = '')
    {
        return (
            new static($url)
        )->method(
            'delete'
        )->body(
            $body
        );
    }

    /**
     *  Alias of delete
     *
     *  @param string   $url
     *  @param string   $body
     *
     *  @return \Blu\Client
     */
    public static function del($url, $body = '')
    {
        return static::delete(
            $url, $body
        );
    }
}
