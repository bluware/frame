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
interface AutoloadInterface
{
    /**
     *  @return void
     */
    public function __construct();

    /**
     * @param string $namespace
     * @param string $dir
     */
    public function add($namespace, $dir);

    /**
     * @param  array  $classmap
     *
     * @return void
     */
    public function classmap(array $classmap);

    /**
     *  @return void
     */
    public function register();

    /**
     *  @param  string $class
     *
     *  @return void
     */
    public function loader($class);
}
