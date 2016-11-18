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
abstract class WritableAbstract extends ReadableAbstract
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
        return $this->set($key, $val);
    }

    /**
     *  @param array $data
     *
     *  @return mixed
     */
    public function replace(array $data)
    {
        $this->data = array_replace($this->data, $data);

        return $this;
    }

    /**
     *  @param array $data
     *
     *  @return mixed
     */
    public function merge(array $data)
    {
        $this->data = array_merge($this->data, $data);

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
        return $this->replace($data);
    }

    /**
     *  @return mixed
     */
    public function __invoke(array $data = null)
    {
        return $this->data($data);
    }
}
