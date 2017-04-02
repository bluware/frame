<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Response\Headers;

/**
 * @subpackage Response
 */
class Response implements IResponse
{
    /**
     *  @var integer
     */
    protected $code;

    /**
     *  @var \Frame\Response\Headers
     */
    protected $headers;

    /**
     *  @var scalar
     */
    protected $body;

    /**
     * @param mixed  $body
     * @param integer $code
     * @param array   $headers
     */
    public function __construct($body, $code = 200, array $headers = [])
    {
        /**
         *  @var integer
         */
        $this->code   = $code;

        /**
         *  @var \Frame\Response\Headers
         */
        $this->headers  = new Headers($headers);

        /**
         *  @var scalar
         */
        $this->body     = gettype($body) === 'object' ?
            $body->__toString() : $body;
    }

    /**
     * @param  scalar   $body
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return Response
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
     * @return Response
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
     * @return Response
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
     * @param  mixed    $body
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return Response
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
     * @param  mixed    $url
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return Response
     */
    public static function redirect($url, $code = 303, array $headers = [])
    {
        return new static(
            null, $code, array_replace($headers, [
                'Location' => $url
            ])
        );
    }

    /**
     * @param  mixed   $url
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return Response
     */
    public static function goto($url, $code = 303, array $headers = [])
    {
        return static::redirect($url, $code, $headers);
    }

    /**
     *  Get code or set current body content.
     *
     *  Usage:
     *      \Frame\Response\Headers headers()
     *      string headers($header)
     *      void   headers($header, $val)
     *
     *  @param array|null $data
     *
     *  @return mixed
     */
    public function headers(array $data = null)
    {
        if ($data === null)
            return $this->headers;

        $this->headers->replace($data);

        return $this;
    }

    /**
     * @param $key
     * @param null $val
     * @return $this|mixed|null
     */
    public function header($key, $val = null)
    {
        if ($val === null)
            return $this->headers->get($key, null);

        $this->headers->set($key, $val);

        return $this;
    }

    /**
     *  Get code or set current body content.
     *
     *  Usage:
     *      string  code()
     *      void    code($code)
     *
     *  @param mixed $code
     *
     *  @return mixed
     */
    public function code($code = null)
    {
        if ($code === null)
            return $this->code;

        $this->code = $code;

        return $this;
    }

    /**
     *  Get code or set current body content.
     *
     *  Usage:
     *      string  code()
     *      void    code($code)
     *
     *  @param mixed $code
     *
     *  @return mixed
     */
    public function status($code = null)
    {
        if ($code === null)
            return $this->code;

        $this->code = $code;

        return $this;
    }

    /**
     *  Get body or set current body content.
     *
     *  Usage:
     *      string  body()
     *      void    body($body)
     *
     *  @param mixed $body
     *
     *  @return mixed
     */
    public function body($body = null)
    {
        if ($body === null)
            return $this->body;

        $this->body = $body;

        return $this;
    }

    /**
     *  Get body or set current body content.
     *
     *  Usage:
     *      string  body()
     *      void    body($body)
     *
     *  @param mixed $body
     *
     *  @return mixed
     */
    public function content($body = null)
    {
        if ($body === null)
            return $this->body;

        $this->body = $body;

        return $this;
    }

    /**
     *  Get body or set current body content.
     *
     *  Usage:
     *      string  body()
     *      void    body($body)
     *
     *  @param bool $apply
     *
     *  @return mixed
     */
    public function render($apply = true)
    {
        if ($apply === true) {
            http_response_code($this->code);

            $this->headers->apply();
        }

        return $this->body;
    }

    /**
     *  Get body or set current body content.
     *
     *  Usage:
     *      string  body()
     *      void    body($body)
     *
     *  @param bool $apply
     *
     *  @return boolean
     */
    public function write($apply = true)
    {
        ob_start();

        echo $this->render($apply);

        ob_end_flush();

        return true;
    }

    /**
     *  @return string
     */
    public function __toString()
    {
        return $this->render(true);
    }
}
