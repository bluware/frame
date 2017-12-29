<?php

namespace Frame\Package;

use Frame\ServiceLocator;

interface IBootstrap
{
    public function bootstrap(ServiceLocator $locator);
}