<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Http\Request;

use Frame\Data\Readable;

/**
 * @subpackage Request
 */
class Query extends Readable
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
}
