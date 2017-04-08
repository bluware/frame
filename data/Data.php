<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\Data\Writable;

class Data extends Writable
{
    /**
     *  @param mixed $data
     */
    public function __construct(array $data = null)
    {
        /*
         * @val bool
         */
        if ($data !== null) {
            /*
             *  @var array
             */
            $this->data = $data;
        }
    }
}
