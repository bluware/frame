<?php

namespace Frame\Package;

use Frame\Autoload;

interface IAutoload
{
    public function autoload(Autoload $autoload);
}