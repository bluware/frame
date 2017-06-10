<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\Locator\Support;
use Frame\Package\IAutoload;
use Frame\Package\IBootstrap;
use Frame\Package\IHook;
use Frame\Package\IRouting;
use Frame\Package\ITranslator;
use Frame\Package\IView;

abstract class PackageAbstract implements IBootstrap, IAutoload, IRouting, IHook, IView, ITranslator
{
    // TODO: all interfaces implementation
}
