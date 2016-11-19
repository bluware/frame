<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Request;

use Frame\Data\Readable;
use Frame\File;

/**
 * @subpackage Request
 */
class Files extends Readable
{
    /**
     *  @param mixed $data
     */
    public function __construct(array $data = null)
    {
        $this->data = $data;
    }

    /**
     *  @param  string $key
     *  @param  mixed  $alternate
     *
     *  @return \Blu\Http\Cookie
     */
    public function get($key, $alternate = null)
    {
        return new File(
            $key, parent::get($key, $alternate)
        );
    }
}
