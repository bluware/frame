<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Essence;

/**
 * @subpackage Essence
 */
abstract class WriteableAbstract extends ReadableAbstract
{
    /**
     *  @param scalar $key
     *  @param mixed  $val
     *
     *  @return \Blu\Essence\WriteableAbstract
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
    *  @return \Blu\Essence\WriteableAbstract
    */
    public function replace(array $data = null)
    {
       if ($data !== null)
           $this->data = array_replace($this->data, $data);

       return $this;
    }

    /**
     *  Alias of replace
     *
     *  @param array $data
     *
     *  @return \Blu\Essence\WriteableAbstract
     */
    public function fill(array $data = null)
    {
       return $this->replace($data);
    }

    /**
     *  @param scalar $key
     *
     *  @return mixed
     */
    public function data($data = null)
    {
        if (is_array($data) === false)
            return parent::data($data);

        return $this->replace($data);
    }
}
