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
abstract class Readable implements \Iterator, \ArrayAccess, \JsonSerializable
{
    /**
     *  @var array
     */
    protected $data     = [];

    /**
     *  @param scalar $key
     *
     *  @return boolean
     */
    public function has($key)
    {
        return array_key_exists(
            $key, $this->data
        );
    }

    /**
     *  @param scalar $key
     *  @param scalar $alternate
     *
     *  @return mixed
     */
    public function get($key, $alternate = null)
    {
        return array_key_exists(
            $key, $this->data
        ) ? $this->data[
            $key
        ] : $alternate;
    }

    /**
     *  @param array $data
     *
     *  @return mixed
     */
    public function diff(array $data)
    {
        return array_diff_assoc(
            $this->data, $data
        );
    }

    /**
     *  @param array $data
     *
     *  @return mixed
     */
    public function intersect(array $data)
    {
        return array_intersect_assoc(
            $this->data, $data
        );
    }

    /**
     *  @param scalar $data
     *  @param scalar $key
     *
     *  @return array
     */
    public function column($val, $key = null)
    {
        /**
         *  @var array
         */
        return array_column(
            $this->data,
            $val,
            $key
        );
    }

    /**
     *  @return void
     */
    public function sort()
    {
        ksort($this->data);

        return $this;
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
     *  Pull multidemential array using \. modifier
     *
     *  @var strict $key
     *
     *  @return bool
     */
    public function pull($key)
    {
        if (strpos($key, '.') === false) {
            return array_key_exists($key, $this->data) ? $this->data[$key] : null;
        }

        $keys = explode('.', $key);

        return $this->__pull(
            $keys, 0, count($keys), $this->data
        );
    }

    /**
     *  Recursion of pull action.
     *
     *  @var array      $keys
     *  @var numeric    $index
     *  @var numeric    $limit
     *  @var mixed     $data
     *
     *  @return mixed
     */
    protected function __pull(array $keys, $index, $limit = null, $data)
    {
        if ($index >= $limit)
            return $data;

        if (array_key_exists($index, $keys) && array_key_exists($keys[$index], $data))
            return call_user_func(
                __METHOD__,
                $keys,
                $index + 1,
                $limit,
                $data[
                    $keys[$index]
                ]
            );

        return null;
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
     *  @return mixed
     */
    public function __invoke()
    {
        return $this->data;
    }

    /**
     *  @return array
     */
    public function jsonSerialize() {
        /**
         *  @var array
         */
        return $this->data;
    }

    /**
     *  @param scalar $key
     *
     *  @return bool
     */
    public function offsetExists($key)
    {
        /**
         *  @var bool
         */
        return array_key_exists(
            $key, $this->data
        );
    }

    /**
     *  @param scalar $key
     *
     *  @return mixed
     */
    public function offsetGet($key)
    {
        /**
         *  @var mixed
         */
        return array_key_exists(
            $key, $this->data
        ) ? $this->data[
            $key
        ] : null;
    }

    /**
     *  @param scalar $key
     *  @param mixed  $value
     *
     *  @return void
     */
    public function offsetSet($key, $value)
    {
        // At this place can be \Exception
    }

    /**
     *  @param scalar $key
     *
     *  @return $this
     */
    public function offsetUnset($key)
    {
        // At this place can be \Exception
    }

    /**
     *  @param scalar $key
     *
     *  @return mixed
     */
    public function to($type)
    {
        switch ($type) {
            case 'array': case 'arr':
                /**
                 *  @var array
                 */
                return $this->data;
                break;

            case 'json':
                /**
                 *  @var string
                 */
                return \Frame\Json::encode(
                    $this->data
                );
                break;

            case 'form':
                /**
                 *  @var string
                 */
                return http_build_query($this->data);
                break;
        }
    }
}
