<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Routing;

use Frame\Data\Writable;

class Routes extends Writable
{
    protected $indexing = -1;

    public function add($type, $path, $call, $options, Group $group = null)
    {
        $route = new Route(
            $type, $path, $call, $group
        );

//        if (count($this->params) > 0) {
//            $route->params($this->params);
//        }

        switch (gettype($options)) {
            case 'array':
                if (array_key_exists('params', $options) === true) {
                    $route->params($options['params']);
                }

                if (array_key_exists('priority', $options) === true) {
                    $route->priority($options['priority']);
                }

                if (array_key_exists('aspect', $options) === true) {
                    $route->aspect($options['aspect']);
                }

                if (array_key_exists('aspects', $options) === true) {
                    $route->aspects($options['aspects']);
                }

                break;

            case 'object':
                if (is_callable($options) === true) {
                    call_user_func($options, $route);
                }

                break;
        }

        $index = sprintf(
            '%d.%d', $route->priority(), ++$this->indexing
        );

        $this->data[$index] = $route;

        return $this;
    }

    public function sort()
    {
        ksort($this->data);
    }
}
