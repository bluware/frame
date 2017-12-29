<?php

/**
 *  Bluware PHP Lite & Scalable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

/**
 * Interface IServiceLocator
 * @package Frame
 */
interface IServiceLocator
{
    /**
     * @return ServiceMediator
     */
    public function getServiceMediator(): ServiceMediator;

    /**
     * @param $serviceInstance
     * @param string|null $interfaceName
     * @throws \Exception
     */
    public function addService($serviceInstance, string $interfaceName = null): void;

    /**
     * @param string $interfaceName
     * @return bool
     */
    public function hasService(string $interfaceName): bool;

    /**
     * @param string $interfaceName
     * @param null $orDefault
     * @return mixed|null
     */
    public function getService(string $interfaceName, $orDefault = null);
}
