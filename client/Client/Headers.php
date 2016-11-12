<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Client;

/**
 * @subpackage Client
 */
class Headers extends \Blu\Data\Writeable
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
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
