<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Data\Writable;

/**
 * @subpackage Data
 */
class Data extends Writable
{
    /**
     *  @param mixed $data
     */
    public function __construct(array $data = null)
    {
        /**
         * @val bool
         */
        if ($data !== null)
            /**
             *  @var array
             */
            $this->data = $data;
    }
}
