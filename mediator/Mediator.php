<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\Mediator\Exception;
use ReflectionFunction          as RF;
use ReflectionFunctionAbstract  as RA;
use ReflectionMethod            as RM;
use ReflectionParameter         as RP;
use ReflectionType              as RT;

class Mediator
{
    /**
     *  @var ServiceLocator
     */
    protected $serviceLocator;

    /**
     *  Mediator constructor.
     *
     *  @param ServiceLocator $locator
     */
    public function __construct(ServiceLocator $locator)
    {
        $this->serviceLocator = $locator;
    }

    /**
     *  @param callable $calle
     *
     *  @return RA
     */
    protected function reflector(callable $calle)
    {
        return is_array(
            $calle
        ) ? new RM(
            $calle[0], $calle[1]
        ) : new RF(
            $calle
        );
    }

    /**
     *  @param RA $calle
     *
     *  @return RP[]
     */
    protected function params(RA $calle)
    {
        return $calle->getParameters();
    }

    /**
     *  @param RP $param
     *
     *  @return RT|bool
     */
    protected function type(RP $param)
    {
        if ($param->hasType() === false) {
            return false;
        }

        $type = $param->getType();

        if ($type->isBuiltin() === true) {
            return false;
        }

        return $type;
    }

    /**
     *  @param string $interface
     *
     *  @return bool
     */
    protected function active($interface)
    {
        return is_subclass_of(
            $interface, ActiveRecord::class
        );
    }

    /**
     *  @param string $interface
     *
     *  @return bool
     */
    protected function locate($interface)
    {
        return $this->getServiceLocator()->has(
            $interface
        );
    }

    /**
     *  @param array    $params
     *  @param RP       $param
     *  @param string   $interface
     */
    protected function insert(array &$params, $param, $interface)
    {
        $instance = $this->getServiceLocator()->get($interface);

        array_splice(
            $params, $param->getPosition(), 0, [$instance]
        );
    }

    /**
     *  @param array    $params
     *  @param RP       $param
     *  @param string   $interface
     *
     *  @return bool
     */
    protected function select(array &$params, $param, $interface)
    {
        /**
         *  @var int
         */
        $place = $param->getPosition();

        $params = array_values($params);

        /**
         *  @var ActiveRecord|null
         */
        $entry = forward_static_call(
            [$interface, 'find'], $params[$place]
        );

        if ($entry === null) {
            return false;
        }

        /*
         *  @var ActiveRecord
         */
        $params[$place] = $entry;

        return true;
    }

    /**
     *  @param array $params
     *  @param RP    $param
     *
     *  @throws \Exception
     *
     *  @return bool
     */
    protected function phase(array &$params, $param)
    {
        $type = $this->type($param);

        if ($type === false) {
            return true;
        }

        $interface = $type->__toString();

        if ($this->active($interface) === true) {
            $success = $this->select(
                $params, $param, $interface
            );

            if ($success === false) {
                return false;
            }
        } elseif ($this->locate($interface) === true) {
            $this->insert(
                $params, $param, $interface
            );
        } else {
            throw new Exception(
                "Instance '{$interface}' missed."
            );
        }

        return true;
    }

    /**
     *  @param callable $calle
     *  @param array $params
     *
     *  @return mixed
     */
    public function dispatch(callable $calle, array $params)
    {
        $reflect = $this->reflector($calle);

        foreach ($this->params($reflect) as $param) {
            if ($this->phase($params, $param) === false) {
                return;
            }
        }

        return call_user_func_array(
            $calle, $params
        );
    }
}
