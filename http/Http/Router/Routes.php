<?php

/**
 *  PHP Lite Frame
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Http\Router;

use Blu\Http\Controller\Core;

/**
 * @subpackage Http
 */
class Routes extends \Blu\Essence\WriteableAbstract
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }
}
