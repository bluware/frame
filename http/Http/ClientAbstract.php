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
