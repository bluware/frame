<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Form;

/**
 * @subpackage Form
 */
class Input
{
    /**
     *  @var mixed
     */
    protected $input    = null;

    /**
     *  @var mixed
     */
    protected $filter   = [];

    /**
     *  @var mixed
     */
    protected $error    = [];

    /**
     *  @var mixed
     */
    protected $message  = null;

    /**
     *  @var boolean
     */
    protected $valid    = false;

    /**
     *  @param mixed $input
     *
     *  @return void
     */
    public function __construct($input = null)
    {
        $this->input = $input;
    }

    /**
     *  @param mixed $input
     *
     *  @return $this
     */
    public function set($input)
    {
        /**
         *  @var mixed
         */
        $this->input = $input;

        /**
         *  @var $this
         */
        return $this;
    }

    /**
     *  @var mixed
     */
    public function filter($names, $value = null)
    {
        /**
         *  @var boolean
         */
        if (gettype($names) === 'array') {
            /**
             *  @var void
             */
            foreach ($names as $name => $value) {
                /**
                 *  @var boolean
                 */
                if (is_numeric($name) === true) {
                    /**
                     *  @var mixed
                     */
                    $this->filter($value, null);
                } else {
                    /**
                     *  @var mixed
                     */
                    $this->filter($name, $value);
                }
            }

            /**
             *  @var $this
             */
            return $this;
        }

        /**
         *  @var mixed
         */
        $value = is_scalar(
            $value
        ) ? [
            $value
        ] : $value;

        /**
         *  @var mixed
         */
        $this->filter[$names] = $value;

        /**
         *  @var $this
         */
        return $this;
    }

    /**
     *  @var mixed
     */
    public function error($names = null, $value = null)
    {
        /**
         *  @var
         */
        if ($names === null)
            /**
             *  @var mixed
             */
            return $this->message;

        /**
         *  @var boolean
         */
        if (gettype($names) === 'array') {
            /**
             *  @var void
             */
            foreach ($names as $name => $value) {
                /**
                 *  @var boolean
                 */
                if (is_numeric($name) === true) {
                    /**
                     *  @var mixed
                     */
                    $this->error($value, null);
                } else {
                    /**
                     *  @var mixed
                     */
                    $this->error($name, $value);
                }
            }

            /**
             *  @var $this
             */
            return $this;
        }

        /**
         *  @var boolean
         */
        if ($value === null) {
            /**
             *  @var scalar
             */
            $value = $names;

            /**
             *  @var string
             */
            $names = 'input';
        }

        /**
         *  @var mixed
         */
        $this->error[$names] = $value;

        /**
         *  @var $this
         */
        return $this;
    }

    /**
     *  @return boolean
     */
    public function filtrate()
    {
        /**
         *  @var boolean
         */
        $this->valid    = true;

        /**
         *  @var void
         */
        foreach ($this->filter as $name => $values) {
            /**
             *  @var boolean
             */
            if (is_callable($values) === true) {
                /**
                 *  @var boolean
                 */
                $valid = call_user_func(
                    $values, $this->input
                );
            } else {
                /**
                 *  @var boolean
                 */
                $values = gettype($values) === 'array' ? $values : [];

                /**
                 *  @var void
                 */
                array_unshift($values, $this->input);

                /**
                 *  @var boolean
                 */
                $valid = forward_static_call_array([
                    Filter::class, $name
                ], $values);
            }

            /**
             *  @var boolean
             */
            if ($valid === false) {
                /**
                 *  @var boolean
                 */
                $this->message = array_key_exists(
                    $name, $this->error
                ) ? $this->error[$name] : (
                        /**
                         *  @var boolean
                         */
                        array_key_exists(
                            'input', $this->error
                        ) ? $this->error['input'] : null
                    );

                /**
                 *  @var boolean
                 */
                return $this->valid = false;
            }
        }

        /**
         *  @var boolean
         */
        return true;
    }

    /**
     *  @return mixed
     */
    public function get()
    {
        /**
         *  @var mixed
         */
        return $this->input;
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
     *  @var $this
     */
    public function is_valid()
    {
        return $this->valid;
    }

    /**
     *  @return mixed
     */
    public function __get($input)
    {
        /**
         *  @var mixed
         */
        return $this->{$input};
    }
}
