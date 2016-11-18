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
class Query extends \Frame\Data\ReadableAbstract
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }
}
