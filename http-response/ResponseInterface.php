<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Http;

/**
 * @subpackage Response
 */
interface ResponseInterface
{
    /**
     * @param scalar  $body
     * @param integer $status
     * @param array   $headers
     */
    public function __construct($body, $code = 200, array $headers = []);

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
    public function headers($header = null, $val = null);

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
    public function code($code = null);

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
    public function body($body = null);
}
