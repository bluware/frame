<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Package
 */
abstract class Package extends Entry
{
    /**
     *  @trait Frame\App\Support
     */
    use Locator\Support;
}
