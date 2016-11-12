<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Data;

use Blu\JSON;

/**
 * @subpackage Essence
 */
abstract class ReadableAbstract implements \Iterator
{
    /**
     *  @var array
     */
    protected $data = [];

    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        $this->data = is_array($data) ? $data : [];
    }

    /**
     *  @param scalar $key
     *
     *  @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     *  @param scalar $key
     *  @param scalar $alternate
     *
     *  @return mixed
     */
    public function get($key, $alternate = null)
    {
        return $this->has($key) ? $this->data[$key] : $alternate;
    }

    /**
     *  @param scalar $key
     *
     *  @return mixed
     */
    public function data()
    {
        return $this->data;
    }

    /**
     *  \Iterator implementation
     *
     *  @return mixed
     */
    function rewind()
    {
        return reset($this->data);
    }

    /**
     *  \Iterator implementation
     *
     *  @return mixed
     */
    function current()
    {
        return current($this->data);
    }

    /**
     *  \Iterator implementation
     *
     *  @return mixed
     */
    function key()
    {
        return key($this->data);
    }

    /**
     *  \Iterator implementation
     *
     *  @return mixed
     */
    function next()
    {
        return next($this->data);
    }

    /**
     *  \Iterator implementation
     *
     *  @return bool
     */
    function valid()
    {
        return key($this->data) !== null;
    }

    /**
     *  @param scalar $key
     *
     *  @return boolean
     */
    public function __isset($key)
    {
        return $this->has($key);
    }

    /**
     *  @param scalar $key
     *
     *  @return mixed
     */
    public function __get($key)
    {
        return $this->get($key, null);
    }

    /**
     *  @param scalar $key
     *
     *  @return mixed
     */
    public function to($type)
    {
        switch ($type) {
            case 'array':
                return $this->data;
                break;

            case 'json':
                return JSON::encode(
                    $this->data
                );
                break;
        }
    }
}
