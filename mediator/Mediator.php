<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use ReflectionFunction;
use ReflectionMethod;

/**
 * @subpackage Mediator
 */
class Mediator
{
    protected $locator;

    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    public function dispatch(callable $calle, array $params)
    {
        $report = is_array($calle) === true ? new ReflectionMethod(
            $calle[0], $calle[1]
        ) : new ReflectionFunction(
            $calle
        );

        $__params = $report->getParameters();

        foreach ($__params as $param) {
            if ($param->hasType() === true) {
                $type = $param->getType();

                if ($type->isBuiltin() === false) {
                    $interface = $type->__toString();
                    $position  = $param->getPosition();
                    $instance  = null;

                    if ($this->locator->has($interface) === true)
                        $instance = $this->locator->get($interface);

                    array_splice(
                        $params, $position, 0, [$instance]
                    );
                } else {
//                    internal type
                }
            }
        }

        return call_user_func_array(
            $calle, $params
        );
    }
}
