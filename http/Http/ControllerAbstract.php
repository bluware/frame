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
abstract class ControllerAbstract
{
    /**
     *  @var boolean
     */
    protected $pass = false;

    /**
     *  @return void
     */
    protected function pass()
    {
        $this->pass = true;

        return $this;
    }

    /**
     *  @return void
     */
    protected function next()
    {
        return $this->pass();
    }

    /**
     *  @return boolean
     */
    protected function passed()
    {
        return $this->pass;
    }

    /**
     *  @param  string $input
     *
     *  @return mixed
     */
    public function request($input = null) {
        return \Blu\Http::request($input);
    }

    /**
     * @param  scalar   $body
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return \Blu\Http\Response
     */
    public function text($body, $code = 200, array $headers = [])
    {
        return \Blu\Http\Response::text($body, $code, $headers);
    }

    /**
     * @param  scalar   $body
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return \Blu\Http\Response
     */
    public function html($body, $code = 200, array $headers = [])
    {
        return \Blu\Http\Response::html($body, $code, $headers);
    }

    /**
     * @param  mixed    $body
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return \Blu\Http\Response
     */
    public function json($body, $code = 200, array $headers = [])
    {
        return \Blu\Http\Response::json($body, $code, $headers);
    }

    /**
     * @param  scalar   $body
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return \Blu\Http\Response
     */
    public function xml($body, $code = 200, array $headers = [])
    {
        return \Blu\Http\Response::xml($body, $code, $headers);
    }

    /**
     * @param  scalar   $url
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return \Blu\Http\Response
     */
    public function redirect($body, $code = 200, array $headers = [])
    {
        return \Blu\Http\Response::text($body, $code, $headers);
    }
}
