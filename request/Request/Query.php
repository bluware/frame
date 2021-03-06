<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Request;

use Frame\Data\Readable;

class Query extends Readable
{
    /**
     *  @param array $data
     */
    public function __construct(array $data = null)
    {
        if ($data !== null) {
            /*
             *  @var array
             */
            return $this->data = $data;
        }
    }
}
