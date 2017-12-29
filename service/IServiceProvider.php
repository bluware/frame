<?php

/**
 *  Bluware PHP Lite & Scalable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

/**
 * Interface IServiceProvider
 * @package Frame
 */
interface IServiceProvider
{
    /**
     * @param ServiceLocator $serviceLocator
     */
    public function setServiceLocator(ServiceLocator $serviceLocator): void;

    /**
     * @return ServiceLocator
     */
    public function getServiceLocator(): ServiceLocator;

    /**
     * @return ServiceMediator
     */
    public function getServiceMediator(): ServiceMediator;

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    public function getService(string $serviceName);

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    public function hasService(string $serviceName): bool;

    /**
     * @param object $serviceInstance
     * @param string|null $serviceName
     * @throws Frame\Exception
     */
    public function addService(object $serviceInstance, string $serviceName = null): void;
}
