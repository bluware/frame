<?php

/**
 *  Bluware PHP Lite Web & API Framework
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\App;
use Frame\Hook;
use Frame\Locator;
use Frame\Http\Request;
use Frame\Http\Response;
use Frame\View;

/**
 * @subpackage Controller
 */
abstract class Controller extends Node
{
    use
        Locator\Support,
        Hook\Support,
        Request\Support,
        Response\Support,
        View\Support;
}
