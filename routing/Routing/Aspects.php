<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Routing;

use Frame\Data\Writable;

class Aspects extends Writable
{
    /**
     *  @return void
     */
    public function get($input, $alt = null)
    {
        /*
         *  @var array
         */
        if ($this->has($input) === true) {
            /*
             *  @var array
             */
            return parent::get($input);
        }

        /**
         *  @var array
         */
        $data = array_flip($this->data);

        /*
         *  @var mixed
         */
        return isset($data[$input]) ?
            $input : $alt;
    }
}
