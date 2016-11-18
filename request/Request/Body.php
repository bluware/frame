<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Request;

/**
 * @subpackage Http
 */
class Body extends \Frame\Data\Readable
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }
}
