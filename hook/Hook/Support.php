<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Hook;

use Frame\Hook;

trait Support
{
    /**
     *  @var \Frame\Hook
     */
    protected $hook;

    /**
     *  @param null $input
     *
     *  @throws Exception
     *
     *  @return \Frame\Hook|mixed
     */
    public function hook($input = null)
    {
        /*
         *  @var boolean
         */
        if ($this->hook === null) {
            /*
             *  @var boolean
             */
            if (property_exists($this, 'locator') === false) {
                /*
                 *  @var Exception
                 */
                throw new Exception(
                    'Hook is null and cannot executed.'
                );
            }

            $this->hook = $this->locator(
                Hook::class
            );
        }

        /*
         *  @var bool
         */
        if ($input === null) {
            /*
             *  @var bool
             */
            return $this->hook;
        }

        /**
         *  @var array
         */
        $params = func_get_args();

        /**
         *  @var string
         */
        $method = array_shift(
            $params
        );

        /*
         *  @var mixed
         */
        return call_user_func_array([
            $this->hook, $method,
        ], $params);
    }
}
