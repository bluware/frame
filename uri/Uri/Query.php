<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Uri;

/**
 * @subpackage Uri
 */
class Query extends \Frame\Data\Writable
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    /**
     *  @param string $type
     *
     *  @return mixed
     */
    public function to($type)
    {
        switch ($type) {
            case 'string':
                /**
                 *  @var string
                 */
                return http_build_query(
                    $this->data
                );

                break;
        }
    }
}
