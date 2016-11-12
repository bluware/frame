<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Client;

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
      *  @var \Blu\Data\Readable
      */
     protected $headers;

     /**
      *  @var \Blu\Data\Readable
      */
     protected $body;

    /**
     *  @param mixed $data
     */
    public function __construct($body, $code, $headers)
    {
        /**
         *  @var $integer
         */
        $this->code = $code;

        /**
         *  @var \Blu\Data\Readable
         */

        $this->headers = new \Blu\Data\Readable(
            is_array($headers) ?
                $headers : $this->parse_header($headers)
        );

        /**
         *  @var string
         */
        $this->body = $body;
    }

    /**
     * [parse_header description]
     * @param  [type] $response [description]
     * @return [type]           [description]
     */
    protected function parse_header($response)
    {
        $headers = array();

        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

        foreach (explode("\r\n", $header_text) as $i => $line)
            if ($i === 0)
                $headers['http_code'] = $line;
            else
            {
                list ($key, $value) = explode(': ', $line);

                $headers[$key] = $value;
            }

        return $headers;
    }

    /**
     *  @return mixed
     */
    public function code()
    {
        return $this->code;
    }

    /**
     *  @return mixed
     */
    public function header($header, $alternate = null)
    {
        return $this->header->get(
            $header, $alternate
        );
    }

    /**
     *  @return mixed
     */
    public function body()
    {
        return $this->body;
    }
}
