<?php

/**
 *  Bluware PHP Lite Web & API Framework.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Response;

use Frame\Data\Writable;

class Headers extends Writable
{
    /**
     *  @param mixed $data
     */
    public function __construct(array $data = null)
    {
        if ($data !== null) {
            /*
             *  @var array
             */
            $this->data = $data;
        }
    }

    public function apply()
    {
        foreach ($this->to('array') as $header) {
            header($header);
        }
    }

    /**
     *  Convert to type.
     *
     *  Usage:
     *      array   to('array');
     *      string  to('string');
     *      string  to('json');
     *
     *  @param string $type
     *
     *  @return mixed
     */
    public function to($type = 'string')
    {
        if ($type === 'array') {
            $data = [];

            foreach ($this as $key => $val) {
                array_push(
                    $data,
                    sprintf(
                        '%s: %s',
                        $key,
                        $val
                    )
                );
            }

            return $data;
        }

        if ($type === 'string') {
            return implode(
                "\n\r", $this->to('array')
            );
        }
    }
}
