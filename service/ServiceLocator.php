<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\Data\Readable;
use Frame\Frame\Exception;

class ServiceLocator implements IServiceLocator
{
    /**
     * @var ServiceMediator
     */
    private $_serviceMediator;

    /**
     * Service Container
     *
     * @var array
     */
    private $_services;

    /**
     * Use for interface link
     *
     * @var array
     */
    private $_aliases;

    /**
     *  Locator constructor.
     */
    public function __construct()
    {
        $this->_services = [];
        $this->_aliases = [];
        $this->_serviceMediator = new ServiceMediator($this);
    }

    /**
     * @return ServiceMediator
     */
    public function getServiceMediator(): ServiceMediator
    {
        return $this->_serviceMediator;
    }

    /**
     * @param $serviceInstance
     * @param string|null $interfaceName
     * @throws \Exception
     */
    public function addService($serviceInstance, string $interfaceName = null): void
    {
        /** @var string $serviceIdentity  */
        $serviceIdentity = null;

        if (is_null($serviceInstance)) {
            throw new \Exception("Service cannot be null.");
        }

        if (is_callable($serviceInstance)) {
            if (is_null($interfaceName)) {
                throw new \Exception("Closure service should have a interface name.");
            }

            $serviceIdentity = $interfaceName;
            $serviceInstance = $this->_serviceMediator->invokeCallable($serviceInstance);
        } else if (is_object($serviceInstance)) {
            $serviceIdentity = get_class($serviceInstance);

            if (!is_null($interfaceName)) {
                $this->_aliases[$interfaceName] = $serviceIdentity;
            }
        } else {
            if (is_string($serviceInstance) && class_exists($serviceInstance)) {
                $serviceIdentity = $interfaceName;

                if (!is_null($interfaceName)) {
                    $this->_aliases[$interfaceName] = $serviceIdentity;
                }

                if (method_exists($serviceInstance, '__construct')) {
                    $serviceInstance = $this->_serviceMediator->invokeCallable($serviceInstance);
                } else {
                    $serviceInstance = new $serviceInstance();
                }
            } else {
                if (is_null($interfaceName)) {
                    throw new \Exception("Closure service should have a interface name.");
                }

                $serviceIdentity = $interfaceName;
            }
        }

        $this->_services[$serviceIdentity] = $serviceInstance;
    }

    /**
     * @param string $interfaceName
     * @return bool
     */
    public function hasService(string $interfaceName): bool
    {
        if (array_key_exists($interfaceName, $this->_aliases)) {
            $interfaceName = $this->_aliases[$interfaceName];
        }

        return array_key_exists($interfaceName, $this->_services);
    }

    /**
     * @param string $interfaceName
     * @param null $orDefault
     * @return mixed|null
     */
    public function getService(string $interfaceName, $orDefault = null)
    {
        if (array_key_exists($interfaceName, $this->_aliases)) {
            $interfaceName = $this->_aliases[$interfaceName];
        }

        return array_key_exists($interfaceName, $this->_services) ? $this->_services[$interfaceName] : $orDefault;
    }
}
