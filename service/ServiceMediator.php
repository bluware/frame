<?php

/**
 *  Bluware PHP Lite & Scalable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionMethod;
use ReflectionParameter;
use ReflectionType;

/**
 * Class ServiceMediator
 * @package Frame
 */
class ServiceMediator implements IServiceMediator
{
    /**
     * @var ServiceLocator
     */
    private $_serviceLocator;

    /**
     * ServiceMediator constructor.
     * @param ServiceLocator $serviceLocator
     */
    public function __construct(ServiceLocator $serviceLocator)
    {
        $this->_serviceLocator = $serviceLocator;
    }

    /**
     * @param callable $callableInstance
     * @param array $callableParameters
     * @return mixed
     */
    public function invokeCallable(callable $callableInstance, array $callableParameters = [])
    {
        /** @var ReflectionParameter[] $reflectionParameters */
        $reflectionParameters = [];

        if (is_array($callableInstance)) {
            list($instanceClass, $instanceMethod) = $callableInstance;

            $reflectionMethod = new ReflectionMethod($instanceClass, $instanceMethod);
            $reflectionParameters = $reflectionMethod->getParameters();
        } else {
            $reflectionFunction = new ReflectionFunction($callableInstance);
            $reflectionParameters = $reflectionFunction->getParameters();
        }

        foreach ($reflectionParameters as $reflectionParameter) {
            $isReflectionParameterUseServiceLocator = false;

            /**
             * If parameter has initialized type
             */
            if ($reflectionParameter->hasType()) {
                $reflectionParameterType = $reflectionParameter->getType();

                if (!$reflectionParameterType->isBuiltin()) {
                    $isReflectionParameterUseServiceLocator = true;
                    $reflectionParameterTypeName = $reflectionParameterType->getName();

                    $serviceInstance = $this->_serviceLocator->getService($reflectionParameterTypeName, null);
                    array_splice($callableParameters, $reflectionParameter->getPosition(), 0, [$serviceInstance]);
                }
            }

            if (!$isReflectionParameterUseServiceLocator) {
                $reflectionParameterName = $reflectionParameter->getName();

                if (array_key_exists($reflectionParameterName, $callableParameters)) {
                    $callableParameterValue = $callableParameters[$reflectionParameterName];
                    unset($callableParameters[$reflectionParameterName]);

                    array_splice($callableParameters, $reflectionParameter->getPosition(), 0, [$callableParameterValue]);
                }
            }
        }

        return call_user_func_array($callableInstance, $callableParameters);
    }
}
