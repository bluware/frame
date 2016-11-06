<?php

/**
 *  Blu | PHP Lite Web & API Framework
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Http;

/**
 * @subpackage Http
 */
abstract class ResponseAbstract
{
    /**
     *  @var integer
     */
    protected $code;

    /**
     *  @var \Blu\Http\Response\Headers
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
         *  @var \Blu\Http\Response\Headers
         */
        $this->headers  = new \Blu\Http\Response\Headers($headers);

        /**
         *  @var scalar
         */
        $this->body     = $body;
    }

    /**
     * [generalize description]
     * @return [type] [description]
     */
    protected function accept()
    {
        foreach ($this->headers as $header => $value) {
            header(
                sprintf('%s: %s', $header, $value)
            );
        }
    }

    /**
     *  @return string
     */
    public function __toString()
    {
        http_response_code($this->status);

        $this->accept();

        return $this->body;
    }
}
