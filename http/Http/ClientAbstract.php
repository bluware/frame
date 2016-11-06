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
abstract class ClientAbstract
{
    /**
     *  @var string
     */
    protected $method = 'GET';

    /**
     *  @var \Blu\Http\URI
     */
    protected $uri;

    /**
     *  @var \Blu\Http\Client\Headers
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
     *  @param string $url
     */
    public function __construct($url)
    {
        /**
         *  @var \Blu\Http\Client\Headers
         */
        $this->headers = new \Blu\Http\Client\Headers();

        /**
         *  @var \Blu\Http\Client\Headers
         */
        $this->uri = is_object(
                 $url
             ) && is_subclass_of(
                 $url, URIAbstract::class
             ) ? $url : new URI($url);
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
     *  @return void
     */
    public function send()
    {
        $request = curl_init();

        curl_setopt_array($request, [
            CURLOPT_CUSTOMREQUEST   => $this->method,
            CURLOPT_URL             => $this->uri->__toString(),
            CURLOPT_RETURNTRANSFER  => 1,
            CURLINFO_HEADER_OUT     => 1,
            CURLOPT_HTTPHEADER      => $this->headers->__toArray(),
            CURLOPT_CONNECTTIMEOUT  => $this->timeout,
            CURLOPT_TIMEOUT         => $this->timeout,
        ]);

        if ($this->method !== 'GET')
            curl_setopt_array($request, [
                CURLOPT_POSTFIELDS => $this->body
            ]);


        if ($this->uri->schema === 'https') {
            curl_setopt_array($request, [
                CURLOPT_SSL_VERIFYPEER  => true,
                CURLOPT_SSL_VERIFYHOST  => false,
            ]);
        }

        $body       = curl_exec($request);
        $code       = curl_getinfo($request, CURLINFO_HTTP_CODE);
        $headers    = curl_getinfo($request, CURLINFO_HEADER_OUT);
        $errno      = curl_errno($request);
        $error      = curl_error($request);

        curl_close($request);

        if ($errno > 0)
            throw new \Blu\Http\Exception(
                "Request failed: " . curl_error($curl), $errno
            );

        return new \Blu\Http\Client\Response(
            $body, $code, $headers
        );
    }
}
