<?php

namespace Frame\Package;

use Frame\Locator;

interface IBootstrap
{
    public function bootstrap(Locator $locator);
}