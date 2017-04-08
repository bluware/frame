<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Form;

class Input
{
    /**
     *  @var mixed
     */
    protected $input = null;

    /**
     *  @var mixed
     */
    protected $default = null;

    /**
     *  @var mixed
     */
    protected $filter = [];

    /**
     *  @var mixed
     */
    protected $error = [];

    /**
     *  @var mixed
     */
    protected $message = null;

    /**
     *  @var bool
     */
    protected $valid = false;

    /**
     *  @param mixed $input
     *
     *  @return void
     */
    public function __construct($input = null)
    {
        /*
         *  @var mixed
         */
        $this->input = $input;

        /*
         *  @var mixed
         */
        $this->default = $input;
    }

    /**
     *  @param mixed $input
     *
     *  @return $this
     */
    public function set($input)
    {
        /*
         *  @var mixed
         */
        $this->input = $input;

        /*
         *  @var $this
         */
        return $this;
    }

    /**
     *  @return mixed
     */
    public function get()
    {
        /*
         *  @var mixed
         */
        return $this->input;
    }

    /**
     *  @return mixed
     */
    public function __get($input)
    {
        /*
         *  @var mixed
         */
        return $this->{$input};
    }

    /**
     *  @var
     */
    public function is($prop, $comparison = null)
    {
        switch ($prop) {
            case 'valid':
                return $this->valid;
                break;
        }
    }

    /**
     *  @var mixed
     */
    public function filter($names, $value = null)
    {
        /*
         *  @var boolean
         */
        if (gettype($names) === 'array') {
            /*
             *  @var void
             */
            foreach ($names as $name => $value) {
                /*
                 *  @var boolean
                 */
                if (is_numeric($name) === true) {
                    /*
                     *  @var mixed
                     */
                    $this->filter($value, null);
                } else {
                    /*
                     *  @var mixed
                     */
                    $this->filter($name, $value);
                }
            }

            /*
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
            $value,
        ] : $value;

        /*
         *  @var mixed
         */
        $this->filter[$names] = $value;

        /*
         *  @var $this
         */
        return $this;
    }

    /**
     *  @var mixed
     */
    public function error($names = null, $value = null)
    {
        /*
         *  @var
         */
        if ($names === null) {
            /*
             *  @var mixed
             */
            return $this->message;
        }

        /*
         *  @var boolean
         */
        if (gettype($names) === 'array') {
            /*
             *  @var void
             */
            foreach ($names as $name => $value) {
                /*
                 *  @var boolean
                 */
                if (is_numeric($name) === true) {
                    /*
                     *  @var mixed
                     */
                    $this->error($value, null);
                } else {
                    /*
                     *  @var mixed
                     */
                    $this->error($name, $value);
                }
            }

            /*
             *  @var $this
             */
            return $this;
        }

        /*
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

        /*
         *  @var mixed
         */
        $this->error[$names] = $value;

        /*
         *  @var $this
         */
        return $this;
    }

    /**
     *  @return bool
     */
    public function filtrate()
    {
        /*
         *  @var boolean
         */
        $this->valid = true;

        /*
         *  @var void
         */
        foreach ($this->filter as $name => $values) {
            /*
             *  @var boolean
             */
            if (is_callable($values) === true) {
                $valid = ($values)($this->input);
            } else {
                /**
                 *  @var bool
                 */
                $values = gettype($values) === 'array' ? $values : [];

                $scalar = in_array($name, [
                    'null',
                    'bool',
                    'boolean',
                    'integer',
                    'int',
                    'float',
                    'numeric',
                    'num',
                    'trim',
                ], true);

                $datetime = in_array($name, [
                    'datetime',
                    'date',
                    'time',
                ], true);

                if ($scalar === true) {
                    /**
                     *  @var bool
                     */
                    $valid = Filter::{$name}(
                        $this->input
                    );
                } elseif ($datetime === true) {
                    $size = count($values) === 0;
                    /**
                     *  @var bool
                     */
                    $valid = $size ? Filter::{$name}(
                        $this->input
                    ) : Filter::{$name}(
                        $this->input,
                        current($values)
                    );
                } else {
                    /*
                     *  @var void
                     */
                    array_unshift($values, $this->input);

                    /**
                     *  @var bool
                     */
                    $valid = forward_static_call_array([
                        Filter::class, $name,
                    ], $values);
                }
            }

            /*
             *  @var boolean
             */
            if ($valid === false) {
                /*
                 *  @var boolean
                 */
                $this->message = array_key_exists(
                    $name, $this->error
                ) ? $this->error[$name] : (
                        /*
                         *  @var boolean
                         */
                        array_key_exists(
                            'input', $this->error
                        ) ? $this->error['input'] : null
                    );

                $this->input = $this->default;

                /*
                 *  @var boolean
                 */
                return $this->valid = false;
            }
        }

        /*
         *  @var boolean
         */
        return true;
    }
}
