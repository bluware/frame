<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Data
 */
class Data extends \Frame\Data\Writable
{
    /**
     *  @param mixed $data
     */
    public function __construct(array $data = null)
    {
        $this->data = $data;
    }
}
