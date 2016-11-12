<?php

/**
 *  PHP Lite Frame
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Http\Request;

use Blu\Essence\Readable;
use Blu\Http\Cookie;

/**
 * @subpackage Http
 */
class Cookies extends Readable
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    /**
     *  @param  string $key
     *  @param  mixed  $alternate
     *
     *  @return \Blu\Http\Cookie
     */
    public function get($key, $alternate = null)
    {
        return new Cookie(
            $key, parent::get($key, $alternate)
        );
    }

    /**
     *  @param mixed $data
     */
    public function to($type)
    {
        parent::__construct($data);
    }
}
