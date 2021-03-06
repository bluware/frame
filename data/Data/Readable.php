<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Data;

abstract class Readable implements \Iterator, \ArrayAccess, \JsonSerializable, \Countable
{
    /**
     *  @var array
     */
    protected $data = [];

    /**
     *  @param $key
     *
     *  @return bool
     */
    public function has($key)
    {
        return array_key_exists(
            $key, $this->data
        );
    }

    /**
     *  @param $keys
     *
     *  @return bool
     */
    public function exists($keys)
    {
        if (gettype($keys) !== 'array') {
            $keys = func_get_args();
        }

        $matches = array_intersect(
            array_keys($this->data), $keys
        );

        return count(
            $matches
        ) === count(
            $keys
        );
    }

    /**
     *  @param $key
     *  @param null $alt
     *
     *  @return mixed|null
     */
    public function get($key, $alt = null)
    {
        return array_key_exists(
            $key, $this->data
        ) ? $this->data[
            $key
        ] : $alt;
    }

    /**
     *  @param $key
     *  @param $val
     *
     *  @return bool
     */
    public function equal($key, $val)
    {
        if (array_key_exists($key, $this->data) === false) {
            return false;
        }

        return $this->data[$key] === $val;
    }

    /**
     *  @param $keys
     *
     *  @return array
     */
    public function only($keys)
    {
        if (gettype($keys) !== 'array') {
            $keys = func_get_args();
        }

        return array_intersect_key(
            $this->data, array_flip($keys)
        );
    }

    /**
     *  @param $keys
     *
     *  @return array
     */
    public function except($keys)
    {
        if (gettype($keys) !== 'array') {
            $keys = func_get_args();
        }

        return array_diff_key(
            $this->data, array_flip($keys)
        );
    }

    /**
     *  @return array
     */
    public function data()
    {
        return $this->data;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     *  @return mixed
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     *  @return mixed
     */
    public function rewind()
    {
        return reset($this->data);
    }

    /**
     *  @return mixed
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     *  @return mixed
     */
    public function next()
    {
        return next($this->data);
    }

    /**
     *  @return bool
     */
    public function valid()
    {
        return key($this->data) !== null;
    }

    /**
     *  @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     *  @param $key
     *  @param null $alt
     *
     *  @return mixed|null
     */
    public function pull($key, $alt = null)
    {
        if (strpos($key, '.') === false) {
            return array_key_exists(
                $key, $this->data
            ) ? $this->data[$key] : $alt;
        }

        $keys = explode('.', $key);

        return $this->__pull(
            $keys, 0, count($keys), $this->data, $alt
        );
    }

    /**
     *  @param array $keys
     *  @param $index
     *  @param null $limit
     *  @param $data
     *  @param null $alt
     *
     *  @return mixed|null
     */
    protected function __pull(array $keys, $index, $limit, $data, $alt = null)
    {
        if ($index >= $limit) {
            return $data;
        }

        if (array_key_exists($index, $keys) && array_key_exists($keys[$index], $data)) {
            return call_user_func(
                __METHOD__,
                $keys,
                $index + 1,
                $limit,
                $data[
                    $keys[$index]
                ],
                $alt
            );
        }

        return $alt;
    }

    /**
     *  @param $key
     *
     *  @return bool
     */
    public function __isset($key)
    {
        return $this->has($key);
    }

    /**
     *  @param $key
     *
     *  @return mixed|null
     */
    public function __get($key)
    {
        return $this->get($key, null);
    }

    /**
     *  @return array
     */
    public function jsonSerialize()
    {
        /*
         *  @var array
         */
        return $this->data;
    }

    /**
     *  @param mixed $key
     *
     *  @return bool
     */
    public function offsetExists($key)
    {
        /*
         *  @var bool
         */
        return array_key_exists(
            $key, $this->data
        );
    }

    /**
     *  @param mixed $key
     *
     *  @return mixed|null
     */
    public function offsetGet($key)
    {
        /*
         *  @var mixed
         */
        return array_key_exists(
            $key, $this->data
        ) ? $this->data[
            $key
        ] : null;
    }

    /**
     *  @param mixed $key
     *  @param mixed $value
     *
     *  @throws Exception
     */
    public function offsetSet($key, $value)
    {
        throw new Exception(
            'Readable data object cannot implement setter. Use writable instead'
        );
    }

    /**
     *  @param mixed $key
     *
     *  @throws Exception
     */
    public function offsetUnset($key)
    {
        throw new Exception(
            'Readable data object cannot implement setter. Use writable instead'
        );
    }

    /**
     *  @param $type
     *
     *  @throws Exception
     *
     *  @return array|string
     */
    public function to($type)
    {
        switch ($type) {
            case 'array': case 'arr': case 'a':
                /*
                 *  @var array
                 */
                return $this->data;
                break;

            case 'json':
                /*
                 *  @var string
                 */
                return \Frame\Json::encode(
                    $this->data
                );
                break;

            case 'form':
                /*
                 *  @var string
                 */
                return http_build_query($this->data);
                break;
        }

        throw new Exception(
            "Convert supports only 'array', 'json' and 'form' types"
        );
    }
}
