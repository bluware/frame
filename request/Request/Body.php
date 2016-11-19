<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Request;

/**
 * @subpackage Request
 */
class Body extends \Frame\Data\Readable
{
    /**
     *  @param mixed $data
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
