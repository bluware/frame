<?php

/**
 *  PHP Lite Frame
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Router;

use Blu\Data\Writeable as Data;
use Blu\AspectInterface;

/**
 * @subpackage Router
 */
class Invokes extends Data
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    /**
     *  Pull invokable controller.
     *
     *  @param  string $name [description]
     *
     *  @return string
     */
    public function controller($name)
    {
        $controller = $this->get($name, $name);

        return is_object($controller) ?
            $controller : new $controller();
    }
}
