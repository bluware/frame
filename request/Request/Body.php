<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Request;

use Frame\Data\Readable;

class Body extends Readable
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
}
