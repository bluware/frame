<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Response
 */
abstract class ResponseAbstract implements ResponseInterface
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
        $this->headers  = new \Frame\Response\Headers($headers);

        /**
         *  @var scalar
         */
        $this->body     = $body;
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

        echo $this->__toString();

        ob_end_flush();
    }

    /**
     *  @return string
     */
    public function __toString()
    {
        http_response_code($this->status);

        ($this->headers)();

        return $this->body;
    }
}
