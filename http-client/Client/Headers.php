<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Http\Client;

use Frame\Data\Writable;

/**
 * @subpackage Http\Client
 */
class Headers extends Writable
{
    /**
     *  @param array $data
     */
    public function __construct(array $data = null)
    {
        if ($data !== null)
            /**
             *  @var array
             */
            $this->data = $data;
    }

    /**
     *  @return string
     */
    public function __toArray($headers = [])
    {
        foreach ($this as $key => $val) {
            array_push(
                $headers, sprintf(
                    '%s: %s', $key, $val
                )
            );
        }

        return $headers;
    }

    /**
     *  @return string
     */
    public function __toString()
    {
        $headers = $this->__toArray();

        return join("\n", $headers);
    }
}
