<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Service\Autoload;
use Frame\Service\Locator;
use Frame\Request;

/**
 * @subpackage Core
 */
class App
{
    public function __construct()
    {
        $locator = Service::locator();

        /**
         *  @var \Frame\Secure
         */
        $locator->add(
            Request::singleton(), 'request'
        );

        /**
         *  @var \Frame\Request
         */
        $locator->add(
            Request::singleton(), 'request'
        );

        /**
         *  @var \Frame\Request
         */
        $locator->add(
            Request::singleton(), 'request'
        );
    }
}
