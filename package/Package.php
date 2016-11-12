<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

/**
 * @subpackage Package
 */
abstract class Package
{
    /**
     *  @return void
     */
    public function __construct()
    {
        foreach (get_class_methods($this) as $method) {
            if ($method !== '__construct')
                $this->{$method}();
        }
    }
}
