<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Uri;

/**
 * @subpackage Uri
 */
class Query extends \Blu\Data\WriteableAbstract
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
