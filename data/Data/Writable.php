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
     *  @param $key
     *  @param $val
     *
     *  @return $this
     */
    public function set($key, $val)
    {
        $this->data[$key] = $val;

        return $this;
    }

    /**
     *  @param $key
     *  @param $val
     *
     *  @return $this
     */
    public function __set($key, $val)
    {
        $this->data[$key] = $val;

        return $this;
    }

    /**
     *  @param $data
     *
     *  @return $this
     *  @throws Exception
     */
    public function replace($data)
    {
        if (is_array($data) === false && $data instanceof Readable === false)
            throw new Exception("Should be array or Writable object");

        $this->data = array_replace(
            $this->data, $data
        );

        return $this;
    }

    /**
     *  @param array $data
     *
     *  @return $this
     *  @throws Exception
     */
    public function merge($data)
    {
        if (is_array($data) === false && $data instanceof Readable === false)
            throw new Exception("Should be array or Writable object");

        $this->data = array_merge(
            $this->data, $data
        );

        return $this;
    }

    /**
     *  @param array|null $data
     *
     *  @return $this|array
     */
    public function data(array $data = null)
    {
        /**
         *  @var array
         */
        if ($data === null)
            return parent::data();

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
     *  @param $key
     *  @param null $value
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
     *  @param array $keys
     *  @param $value
     *  @param $index
     *  @param int $limit
     *  @param $data
     *
     *  @return mixed
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
     *  @param mixed $key
     *  @param mixed $value
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
     *      @param mixed $key
     */
    public function offsetUnset($key) {
        /**
         *  @var void
         */
        unset(
            $this->data[$key]
        );
    }
}
