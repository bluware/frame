<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu;

use Blu\Service;
use Blu\Request;

/**
 * @subpackage Core
 */
class App
{
    public function __construct()
    {
        $locator = Service::locator();

        /**
         *  @var \Blu\Secure
         */
        $locator->add(
            Request::singleton(), 'request'
        );

        /**
         *  @var \Blu\Request
         */
        $locator->add(
            Request::singleton(), 'request'
        );

        /**
         *  @var \Blu\Request
         */
        $locator->add(
            Request::singleton(), 'request'
        );
    }
}
