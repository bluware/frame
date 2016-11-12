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
interface CookieInterface
{
    /**
     *
     *  @param string  $name
     *  @param string  $input
     *  @param integer $expire
     *  @param string  $path
     *  @param string  $domain
     *  @param boolean $secure
     *  @param boolean $http
     *
     *  @return void
     */
    public function __construct(
        $name,
        $input      = null,
        $expire     = 0,
        $path       = '/',
        $domain     = null,
        $secure     = false,
        $http       = true
    );

    /**
     *  Getter for input property.
     *
     *  @return string
     */
    public function get();

    /**
     *  Setter for input property.
     *
     *  @param string $input
     *
     *  @return mixed
     */
    public function set($input);

    /**
     *  Input get|set method .
     *
     *  @param mixed $input
     *
     *  @return mixed
     */
    public function input($input = null);

    /**
     *  Get cookie name prop.
     *
     *  @return string
     */
    public function name();

    /**
     *  Complex expire method. Set 0 for session and grater 0 for expire.
     *
     *  @param mixed $expire
     *
     *  @return mixed
     */
    public function expire($expire = null);

    /**
     *  Complex get|set path prop.
     *
     *  @param mixed $path
     *
     *  @return mixed
     */
    public function path($path = null);

    /**
     *  Complex get|set domain prop.
     *
     *  @param mixed $path
     *
     *  @return mixed
     */
    public function domain($domain = null);

    /**
     *  Complex get|set secure prop.
     *
     *  @param mixed $path
     *
     *  @return mixed
     */
    public function secure($secure = null);

    /**
     *  Complex get|set httpOnly prop.
     *
     *  @param mixed $path
     *
     *  @return mixed
     */
    public function http($http = null);

    /**
     *  Save cookie with $expire set.
     *
     *  @param mixed $expire
     *  @param mixed $input
     *
     *  @return void
     */
    public function touch($expire = null, $input = null);

    /**
     *  Save cookie with $input set.
     *
     *  @param mixed $input
     *
     *  @return void
     */
    public function save($input = null);

    /**
     *  Remove cookie.
     *
     *  @return void
     */
    public function forget();
}
