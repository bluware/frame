<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

class Hook extends Data
{
    /**
     *  @param  string   $name
     *  @param  callable $call
     *  @param  int  $priority
     *
     *  @return $this
     */
    public function event($name, callable $call, $priority = 50)
    {
        $group = $this->get(
            $name, []
        );

        $token = sprintf(':%d.%s.%d',
            str_pad(
                $priority,
                4,
                0,
                STR_PAD_LEFT
            ), uniqid(), rand(
                10000000,
                99999999
            )
        );

        $group[$token] = $call;

        $this->set(
            $name, $group
        );

        return $this;
    }

    /**
     *  @param  string $event
     *
     *  @return $this
     */
    public function anchor($event)
    {
        /**
         *  @var array
         */
        $data = func_get_args();

        /*
         *  @var mixed
         */
        array_shift($data);

        /**
         *  @var mixed
         */
        $group = $this->get($event, []);

        ksort($group);

        foreach ($group as $call) {
            call_user_func_array(
                $call, $data
            );
        }

        /*
         *  @var $this
         */
        return $this;
    }
}
