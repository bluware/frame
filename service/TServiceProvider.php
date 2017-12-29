<?php

/**
 *  Bluware PHP Lite & Scalable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

/**
 * Trait ServiceTrait
 * @package Frame
 */
trait TServiceProvider
{
    /**
     *  @var \Frame\ServiceLocator
     */
    private $_serviceLocator;

    /**
     * @param ServiceLocator $locator
     */
    private function setServiceLocator(ServiceLocator $locator): void
    {
        $this->_serviceLocator = $locator;
    }

    /**
     * @return ServiceLocator
     */
    public function getServiceLocator(): ServiceLocator
    {
        return $this->_serviceLocator;
    }

    /**
     * @return ServiceMediator
     */
    public function getServiceMediator(): ServiceMediator
    {
        return $this->_serviceLocator->getServiceMediator();
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    public function getService(string $serviceName)
    {
        return $this->_serviceLocator->getService($serviceName);
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    public function hasService(string $serviceName): bool
    {
        return $this->_serviceLocator->hasService($serviceName);
    }

    /**
     * @param object $serviceInstance
     * @param string|null $serviceName
     * @throws \Exception
     */
    public function addService(object $serviceInstance, string $serviceName = null): void
    {
        $this->_serviceLocator->addService($serviceInstance, $serviceName);
    }
}
