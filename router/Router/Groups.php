<?php

/**
 *  PHP Lite Frame
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Router;

use Blu\Data\Writeable as Data;

/**
 * @subpackage Router
 */
class Groups extends Data
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    public function from($type, $data)
    {
        switch ($type) {
            case 'array':
                $this->data = $data;
                break;

            default:
                # code...
                break;
        }
    }

    public function to($type)
    {
        switch ($type) {
            case 'array':
                return $this->data;
                break;

            default:
                # code...
                break;
        }
    }

    public function clean()
    {
        $this->data = [];
    }
}
