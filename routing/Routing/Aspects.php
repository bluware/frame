<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Routing;

use Frame\Data\Writable;

/**
 * @subpackage Routing
 */
class Aspects extends Writable
{
    /**
     *  @return void
     */
    public function get($input, $alternate = null)
    {
        /**
         *  @var array
         */
        if ($this->has($input) === true)
            /**
             *  @var array
             */
            return parent::get($input);

        /**
         *  @var array
         */
        $data = array_flip($this->data);

        /**
         *  @var mixed
         */
        return isset($data[$input]) ?
            $input : $alternate;
    }
}
