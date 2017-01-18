<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Data;

/**
 * @subpackage Data
 */
abstract class Writable extends Readable
{
    /**
     *  @param scalar $key
     *  @param mixed  $val
     *
     *  @return \Frame\Data\Write
     */
    public function set($key, $val)
    {
        $this->data[$key] = $val;

        return $this;
    }

    /**
     *  @param scalar $key
     *  @param mixed  $val
     *
     *  @return mixed
     */
    public function __set($key, $val)
    {
        $this->data[$key] = $val;
    }

    /**
     *  @param array $data
     *
     *  @return mixed
     */
    public function replace(array $data)
    {
        $this->data = array_replace(
            $this->data, $data
        );

        return $this;
    }

    /**
     *  @param array $data
     *
     *  @return mixed
     */
    public function merge(array $data)
    {
        $this->data = array_merge(
            $this->data, $data
        );

        return $this;
    }

    /**
     *  @param scalar $key
     *
     *  @return mixed
     */
    public function data(array $data = null)
    {
        /**
         *  @var array
         */
        if ($data === null)
            return parent::data($data);

        /**
         *  @var void
         */
        $this->data = array_replace(
            $this->data, $data
        );

        /**
         *  @var $this
         */
        return $this;
    }

    /**
     *  @var mixed $key
     *  @var mixed $value
     *
     *  @return $this
     */
    public function push($key, $value = null)
    {
        if (strpos($key, '.') === false) {
            $this->data[$key] = $value;
        } else {
            $keys = explode('.', $key);

            $this->data = $this->__push(
                $keys, $value, 0, count($keys), $this->data
            );
        }

        return $this;
    }

    /**
     *  @var array   $key
     *  @var mixed   $value
     *  @var numeric $index
     *  @var numeric $limit
     *  @var array   $data
     *
     *  @return $this
     */
    public function __push(array $keys, $value, $index, $limit = 0, $data)
    {
        if ($index >= $limit)
            return $value;

        $data[$keys[$index]] = call_user_func(
            __METHOD__,
            $keys,
            $value,
            $index + 1,
            $limit,
            isset(
                $data[$keys[$index]]
            ) ? $data[$keys[$index]] : []
        );

        return $data;
    }

    /**
     *  @param scalar $key
     *  @param mixed  $value
     *
     *  @return void
     */
    public function offsetSet($key, $value) {
        /**
         *  @var bool
         */
        if (
            array_key_exists($key, $this->data)
        ) {
            /**
             *  @var mixed
             */
            $this->data[] = $value;
        } else {
            /**
             *  @var mixed
             */
            $this->data[$key] = $value;
        }
    }

    /**
     *  @param scalar $key
     *
     *  @return $this
     */
    public function offsetUnset($key) {
        /**
         *  @var void
         */
        unset(
            $this->data[$key]
        );
    }

    /**
     *  @return mixed
     */
    public function __invoke(array $data = null)
    {
        /**
         *  @var array
         */
        if ($data === null)
            return parent::data($data);

        /**
         *  @var void
         */
        $this->data = array_replace(
            $this->data, $data
        );

        /**
         *  @var $this
         */
        return $this;
    }
}
