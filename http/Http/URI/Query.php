<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Http\URI;

/**
 * @subpackage Http
 */
class Query extends \Blu\Essence\WriteableAbstract
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    /**
     *  @return string
     */
    public function __toString()
    {
        return http_build_query(
            $this->data
        );
    }
}
