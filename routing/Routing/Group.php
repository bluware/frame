<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Routing;

use Frame\Data\Writable;

class Group extends Writable
{
    /**
     * @var int
     */
    protected $overload = 0;

    protected $data = [
        'namespace' => null,
        'prefix'    => null,
        'params'    => [],
        'aspects'   => [],
        'priority'  => 50,
    ];

    public function namespace($namespace = null)
    {
        if ($namespace === null) {
            return $this->get('namespace');
        }

        if ($this->overloaded() === true) {
            throw new Exception('Routing group is overloaded for global settings.');
        }
        $this->set('namespace', $namespace);

        return $this;
    }

    public function prefix($prefix = null)
    {
        if ($prefix === null) {
            return $this->get('prefix');
        }

        if ($this->overloaded() === true) {
            throw new Exception('Routing group is overloaded for global settings.');
        }
        $this->set('prefix', $prefix);

        return $this;
    }

    public function param($key, $val = null)
    {
        $key = sprintf('params.%s', $key);

        if ($val === null) {
            $this->pull($key);
        }

        if ($this->overloaded() === true) {
            throw new Exception('Routing group is overloaded for global settings.');
        }
        $this->push($key, $val);

        return $this;
    }

    public function params(array $keys = null)
    {
        if ($keys === null) {
            return $this->get('params');
        }

        if ($this->overloaded() === true) {
            throw new Exception('Routing group is overloaded for global settings.');
        }
        $this->set(
            'params', array_replace($this->get('params'), $keys)
        );

        return $this;
    }

    public function aspect($aspect)
    {
        if (in_array($aspect, $this->get('aspects'), true) === false) {
            $aspects = &$this->get('aspects');

            $aspects[] = $aspect;

            $this->set('aspects', $aspects);
        }

        return $this;
    }

    public function aspects(array $aspects = null)
    {
        if ($aspects === null) {
            return $this->aspects;
        }

        foreach ($aspects as $aspect) {
            if (in_array($aspect, $this->get('aspects'), true) === false) {
                $aspects = $this->get('aspects');

                $aspects[] = $aspect;

                $this->set('aspects', $aspects);
            }
        }

        return $this;
    }

    public function snapshot()
    {
        ++$this->overload;

        return $this->data;
    }

    public function restore(array $group)
    {
        --$this->overload;

        $this->data = $group;
    }

    public function overloaded()
    {
        return $this->overload > 0;
    }
}
