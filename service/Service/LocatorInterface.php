<?php

/**
 *  Blu | PHP Lite Web & API Framework
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Service;

/**
 * @subpackage Service
 */
interface LocatorInterface
{
    /**
     *  @param  mixed   $service
     *  @param  string  $alias
     *
     *  @return void
     */
    public function add($service, $alias);

    /**
     *  @param  string  $key
     *
     *  @return boolean
     */
    public function has($key);

    /**
     *  @param  string  $key
     *  @param  mixed   $alternate
     *
     *  @return mixed
     */
    public function get($key, $alternate = null);
}
