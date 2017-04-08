<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\Config\Exception;
use Frame\Data\Writable;

class Config extends Writable
{
    /**
     *  Config constructor.
     *
     *  @param array $source
     *
     *  @throws Exception
     */
    public function __construct($source = [])
    {
        switch (gettype($source)) {
            case 'string':

                if (is_file($source) === false) {
                    throw new Exception(
                        "Configuration file '{$source}' missed."
                    );
                }

                $source = include $source;

                if (gettype($source) !== 'array') {
                    throw new Exception(
                        'Configuration file should return Array.'
                    );
                }

                $this->data = $source;
                break;

            case 'array':
                $this->data = $source;
                break;

            default:
                throw new Exception(
                    'Configuration should be File or Array.'
                );
                break;
        }
    }
}
