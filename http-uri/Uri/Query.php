<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Http\Uri;

use Frame\Data\Writable;

/**
 * @subpackage Uri
 */
class Query extends Writable
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