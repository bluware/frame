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
    public function filtrate()
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
     *  @var $this
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
     *  @param scalar $key
     *  @param scalar $alternate
     *
     *  @return mixed
     */
    public function get($key, $alternate = null)
    {
        return $this->has($key) ? $this->data[$key]->get() : $alternate;
    }

    /**
     *  @param array $data
     *
     *  @return mixed
     */
    public function diff(array $data)
    {
        return array_diff_assoc(
            $this->data(), $data
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
            $this->data(), $data
        );
    }

    /**
     *  @param scalar $key
     *  @param mixed  $val
     *
     *  @return \Frame\Data\Write
     */
    public function set($key, $val)
    {
        $this->data[$key]->set($val);

        return $this;
    }

    /**
     *  @param array $data
     *
     *  @return mixed
     */
    public function replace(array $data)
    {
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
     *  @return mixed
     */
    public function merge(array $data)
    {
        $data = array_merge(
            $this->data(), $data
        );

        foreach ($data as $key => $value)
            if ($this->has($key) === true)
                $this->data[$key]->set($value);

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
        if ($data !== null) {
            /**
             *  @var $this
             */
            return $this->replace($data);
        }

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
     *  @param  Readable $data
     *
     *  @return void
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
        return $this->data(
            $data
        )->filtrate();
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
