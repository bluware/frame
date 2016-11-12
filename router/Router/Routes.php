<?php

/**
 *  PHP Lite Frame
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Router;

use Blu\Router\Routes\Route;
use Blu\Data\Writeable as Data;

/**
 * @subpackage Http
 */
class Routes extends Data
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    /**
     *  @param  array   $route
     *  @param  integer $priority
     *
     *  @return void
     */
    public function push(Route $route, $priority = 0)
    {
        $this->set(
            sprintf(
                ':%s:%s:%s',
                str_pad(
                    $priority,
                    4, 0,
                    STR_PAD_LEFT
                ), rand(
                    1000000000000,
                    9999999999999
                ), uniqid()
            ), $route
        );

        return $this;
    }

    /**
     *  @return void
     */
    public function sort()
    {
        ksort($this->data);

        return $this;
    }

    /**
     *  @return void
     */
    public function __invoke()
    {
        return $this->sort();
    }
}
