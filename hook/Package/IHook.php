<?php

namespace Frame\Package;

use Frame\Hook;

interface IHook
{
    public function hook(Hook $hook);
}