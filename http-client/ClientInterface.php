<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Http;

/**
 * @subpackage Client
 */
interface ClientInterface
{
    /**
     *  @param string $url
     */
    public function __construct($url);

    /**
     *  @param string   $url
     *
     *  @return \Blu\Client
     */
    public static function get($url);

    /**
     *  @param string   $url
     *  @param string   $body
     *
     *  @return \Blu\Client
     */
    public static function post($url, $body = '');

    /**
     *  @param string   $url
     *  @param string   $body
     *
     *  @return \Blu\Client
     */
    public static function put($url, $body = '');

    /**
     *  @param string   $url
     *  @param string   $body
     *
     *  @return \Blu\Client
     */
    public static function delete($url, $body = '');

    /**
     *  Alias of delete
     *
     *  @param string   $url
     *  @param string   $body
     *
     *  @return \Blu\Client
     */
    public static function del($url, $body = '');

    /**
     *  @param  mixed $method
     *
     *  @return mixed
     */
    public function method($method = null);

    /**
     *  @param  mixed $timeout
     *
     *  @return mixed
     */
    public function timeout($timeout = null);

    /**
     *  @param  mixed $body
     *
     *  @return mixed
     */
    public function query(array $query = null);

    /**
     *  @param  mixed $body
     *
     *  @return mixed
     */
    public function header($header, $val = null);

    /**
     *  @param  mixed $body
     *
     *  @return mixed
     */
    public function headers(array $headers = null);

    /**
     *  @param  mixed $body
     *
     *  @return mixed
     */
    public function body($body = null);

    /**
     *  @return mixed
     */
    public function curlopt(array $curlopt = null);

    /**
     *  @return void
     */
    public function send();

    /**
     *  @return void
     */
    public function make();
}
