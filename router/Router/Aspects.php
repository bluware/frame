<?php

/**
 *  PHP Lite Frame
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Router;

use Blu\Data\Writeable as Data;
use Blu\AspectInterface;

/**
 * @subpackage Router
 */
class Aspects extends Data
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    /**
     *  @param mixed $data
     */
    public function prepare(
        AspectInterface $aspect,
        $params,
        &$passed = false
    ) {
        $response = $aspect->handle($params);

        $passed   = $aspect->passed();

        if ($passed === true)
            return null;

        return $response;
    }
}
