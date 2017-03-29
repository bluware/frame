<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Data\Readable;
use Frame\Data\Writable;
use Frame\Form\Input;

/**
 * @subpackage Form
 */
class Form extends Writable implements FormInterface
{
    /**
     *  @var array
     */
    protected $error;

    /**
     *  @var boolean
     */
    protected $valid    = true;

    /**
     *  @param  mixed $name
     *  @param  mixed $value
     *
     *  @return mixed
     */
    public function input($name, $value = null)
    {
        if ($this->has($name) === true)
            return $this->data[$name];

        /**
         *  @var Input
         */
        $input = new Input($value);

        /**
         *  @var Input
         */
        $this->data[$name] = $input;

        /**
         *  @var Input
         */
        return $input;
    }

    /**
     *  @return boolean
     */
    public function validate()
    {
        /**
         *  @var boolean
         */
        $this->valid = true;

        /**
         *  @var boolean
         */
        $this->error = [];

        /**
         *  @var void
         */
        foreach ($this as $name => $input) {
            /**
             *  @var boolean
             */
            $valid = $input->filtrate();

            /**
             *  @var boolean
             */
            if ($valid === false) {
                /**
                 *  @var boolean
                 */
                $this->valid = false;

                /**
                 *  @var mixed
                 */
                $error = $input->error();

                /**
                 *  @var boolean
                 */
                if ($error !== null)
                    /**
                     *  @var boolean
                     */
                    $this->error[$name] = $error;
            }
        }

        /**
         *  @var boolean
         */
        return $this->valid;
    }

    /**
     *  @return boolean
     */
    public function filtrate()
    {
        /**
         *  @return boolean
         */
        return $this->validate();
    }

    /**
     *  @return array
     */
    public function error()
    {
        /**
         *  @return array
         */
        return $this->error;
    }

    /**
     * @param $prop
     * @param null $comparison
     * @return mixed
     */
    public function is($prop, $comparison = null)
    {
        return $this->{
            sprintf('is_%s', $prop)
        }($comparison);
    }

    /**
     *  @return mixed
     */
    public function is_valid()
    {
        return $this->valid;
    }

    /**
     *  @param $key
     *  @param null $alt
     *
     *  @return null
     */
    public function get($key, $alt = null)
    {
        return $this->has($key) ? $this->data[$key]->get() : $alt;
    }

    /**
     *  @param $data
     *
     *  @return array
     *  @throws \Exception
     */
    public function diff($data)
    {
        if (is_array($data) === false && $data instanceof Readable === false)
            throw new \Exception("Should be array or Readable object");

        return array_diff_assoc(
            $this->data(), $data
        );
    }

    /**
     *  @param $data
     *
     *  @return array
     *  @throws \Exception
     */
    public function intersect($data)
    {
        if (is_array($data) === false && $data instanceof Readable === false)
            throw new \Exception("Should be array or Readable object");

        return array_intersect_assoc(
            $this->data(), $data
        );
    }

    /**
     *  @param $key
     *  @param $val
     *
     *  @return $this
     */
    public function set($key, $val)
    {
        $this->data[$key]->set($val);

        return $this;
    }

    /**
     *  @param $data
     *
     *  @return $this
     *  @throws \Exception
     */
    public function replace($data)
    {
        if (is_array($data) === false && $data instanceof Readable === false)
            throw new \Exception("Should be array or Readable object");

        $data = array_replace(
            $this->data(), $data
        );

        foreach ($data as $key => $value)
            if ($this->has($key) === true)
                $this->data[$key]->set($value);

        return $this;
    }

    /**
     *  @param array $data
     *
     *  @return $this
     *  @throws \Exception
     */
    public function merge($data)
    {
        if (is_array($data) === false && $data instanceof Readable === false)
            throw new \Exception("Should be array or Readable object");

        $data = array_merge(
            $this->data(), $data
        );

        foreach ($data as $key => $value)
            if ($this->has($key) === true)
                $this->data[$key]->set($value);

        return $this;
    }

    /**
     *  @param null $data
     *
     *  @return array|mixed|null
     *  @throws \Exception
     */
    public function data($data = null)
    {
        /**
         *  @var array
         */
        if ($data !== null) {
            /**
             *  @var $this
             */
            return $this->replace($data);
        }

        if (is_array($data) === false && $data instanceof Readable === false)
            throw new \Exception("Should be array or Readable object");

        /**
         *  @var array
         */
        $data = [];

        /**
         *  @var array
         */
        foreach ($this as $key => $input)
            $data[$key] = $input->get();

        /**
         *  @var array
         */
        return $data;
    }

    /**
     * @param Readable $data
     * @return bool
     */
    public function apply(Readable $data)
    {
        /**
         *  @var array
         */
        $data = $data->to('array');

        /**
         *  @var array
         */
        $this->data($data);

        return $this->filtrate();
    }

    /**
     * @param $type
     * @return array|mixed|null|string
     */
    public function to($type)
    {
        switch ($type) {
            case 'array':
                /**
                 *  @var array
                 */
                return $this->data();
                break;

            case 'json':
                /**
                 *  @var string
                 */
                return \Frame\Json::encode(
                    $this->data()
                );
                break;
        }
    }
}
