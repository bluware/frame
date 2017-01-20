<?php

/**
 *  Frame Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Http\Client;

/**
 * @subpackage Http\Client
 */
class Response
{
    /**
     *  @var integer
     */
    protected $code;

     /**
      *  @var \Frame\Data\Readable
      */
     protected $headers;

     /**
      *  @var \Frame\Data\Readable
      */
     protected $cookies;

     /**
      *  @var \Frame\Data\Readable
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
         *  @var \Frame\Data
         */

        $this->cookies = new \Frame\Data();

        /**
         *  @var \Frame\Data
         */
        $this->headers = new \Frame\Data(
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
            if ($i === 0) {
                $headers['http_code'] = $line;
            } else {
                list ($key, $value) = explode(': ', $line);

                if ($key === 'Set-Cookie') {
                    preg_match('/^(.*?)=(.*?)(\;|$)/i', $value, $matches);

                    array_shift($matches);

                    list($ckey, $cval) = $matches;

                    $this->cookies->set(
                        $ckey, $cval
                    );
                }

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
    public function header($header, $alt = null)
    {
        return $this->headers->get(
            $header, $alt
        );
    }

    /**
     *  @return mixed
     */
    public function cookie($key, $alt = null)
    {
        return $this->cookies->get(
            $key, $alt
        );
    }

    /**
     *  @return mixed
     */
    public function body()
    {
        return $this->body;
    }

    /**
     *  @return mixed
     */
    public function __get($input)
    {
        return $this->{$input};
    }
}
