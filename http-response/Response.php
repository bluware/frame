<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Http;

use Frame\Http\Response\Headers;

/**
 * @subpackage Response
 */
class Response implements ResponseInterface
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
     * @param scalar  $body
     * @param integer $status
     * @param array   $headers
     */
    public function __construct($body, $code = 200, array $headers = [])
    {
        /**
         *  @var integer
         */
        $this->status   = $code;

        /**
         *  @var \Frame\Response\Headers
         */
        $this->headers  = new Headers($headers);

        /**
         *  @var scalar
         */
        $this->body     = $body;
    }

    /**
     * @param  scalar   $body
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return \Blu\Response
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
     * @return \Blu\Response
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
     * @return \Blu\Response
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
     * @return \Blu\Response
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
     * @return \Blu\Response
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
     * @param  scalar   $url
     * @param  integer  $code
     * @param  array    $headers
     *
     * @return \Blu\Response
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
     *  @param mixed $code
     *
     *  @return mixed
     */
    public function headers($header = null, $val = null)
    {
        if ($header === null)
            return $this->headers;

        if ($val === null)
            return $this->headers
                ->get($val);

        $this->headers
            ->set(
                $header, $val
            );

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

    public function print()
    {
        ob_start('ob_gzhandler');

        http_response_code($this->status);

        ($this->headers)();

        echo $this->body;

        ob_end_flush();
    }
}
