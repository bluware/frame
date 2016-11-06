<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Http\Client;

/**
 * @subpackage Http
 */
class Response
{
    /**
     *  @var integer
     */
    protected $code;

     /**
      *  @var \Blu\Essence\Readable
      */
     protected $headers;

     /**
      *  @var \Blu\Essence\Readable
      */
     protected $body;

    /**
     *  @param mixed $data
     */
    public function __construct($body, $code, array $headers)
    {
        /**
         *  @var $integer
         */
        $this->code = $code;

        /**
         *  @var \Blu\Essence\Readable
         */

        $this->headers = new \Blu\Essence\Readable(
            $headers
        );

        /**
         *  @var string
         */
        $this->body = $body;
    }
}
