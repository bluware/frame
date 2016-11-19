<?php

/**
 *  PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Rest;

use Frame\Rest\Client\Headers;
use Frame\Rest\Client\Response;
use Frame\Uri;
use Frame\UriAbstract;

/**
 * @subpackage Client
 */
abstract class ClientAbstract
{
    /**
     *  @var string
     */
    protected $method = 'GET';

    /**
     *  @var \Frame\Uri
     */
    protected $uri;

    /**
     *  @var \Frame\Client\Headers
     */
    protected $headers;

    /**
     *  @var scalar
     */
    protected $body;

    /**
     *  @var numeric
     */
    protected $timeout = 10;

    /**
     *  @var array
     */
    protected $curlopt;

    /**
     *  @param string $url
     */
    public function __construct($url)
    {
        /**
         *  @var \Frame\Client\Headers
         */
        $this->headers = new Headers();

        /**
         *  @var \Frame\Client\Headers
         */
        $this->uri = is_object(
                 $url
             ) && is_subclass_of(
                 $url, UriAbstract::class
             ) ? $url : new Uri($url);

        /**
         *  @var array
         */
        $this->curlopt = [
            CURLOPT_RETURNTRANSFER  => 1,
            CURLINFO_HEADER_OUT     => 1,
            CURLOPT_SSL_VERIFYPEER  => true,
        ];
    }

    /**
     *  @param  mixed $method
     *
     *  @return mixed
     */
    public function method($method = null)
    {
        if ($method === null)
            return $this->method;

        $this->method = strtoupper($method);

        return $this;
    }

    /**
     *  @param  mixed $timeout
     *
     *  @return mixed
     */
    public function timeout($timeout = null)
    {
        if ($timeout === null)
            return $this->timeout;

        $this->timeout = $timeout;

        return $this;
    }

    /**
     *  @param  mixed $body
     *
     *  @return mixed
     */
    public function query(array $query = null)
    {
        if ($query === null)
            return $this->uri->query;

        $this->uri->query
            ->replace($query);

        return $this;
    }

    /**
     *  @param  mixed $body
     *
     *  @return mixed
     */
    public function header($header, $val = null)
    {
        if ($value === null)
            return $this->headers
                ->get($header);

        $this->headers
            ->set($header, $val);

        return $this;
    }

    /**
     *  @param  mixed $body
     *
     *  @return mixed
     */
    public function headers(array $headers = null)
    {
        if ($headers === null)
            return $this->headers;

        $this->headers
            ->replace($headers);

        return $this;
    }

    /**
     *  @param  mixed $body
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
     *  @return mixed
     */
    public function curlopt(array $curlopt = null)
    {
        if ($curlopt === null)
            return $this->curlopt;

        $this->curlopt = array_replace(
            $this->curlopt, $curlopt
        );

        return $this;
    }

    /**
     *  @return void
     */
    public function make(array $curlopt = null)
    {
        $request = curl_init();

        curl_setopt_array(
            $request, array_replace($this->curlopt, [
                CURLOPT_CUSTOMREQUEST   => $this->method,
                CURLOPT_CONNECTTIMEOUT  => $this->timeout,
                CURLOPT_TIMEOUT         => $this->timeout,
                CURLOPT_URL             => $this->uri->__toString(),
                CURLOPT_HTTPHEADER      => $this->headers->__toArray(),
            ])
        );

        if ($this->method !== 'GET')
            curl_setopt_array($request, [
                CURLOPT_POSTFIELDS => $this->body
            ]);

        $body       = curl_exec($request);
        $code       = curl_getinfo($request, CURLINFO_HTTP_CODE);
        $headers    = curl_getinfo($request, CURLINFO_HEADER_OUT);
        $errno      = curl_errno($request);
        $error      = curl_error($request);

        curl_close($request);

        if ($errno > 0)
            throw new \Exception(
                "Request failed: " . $error, $errno
            );

        return new Response(
            $body, $code, $headers
        );
    }
}
