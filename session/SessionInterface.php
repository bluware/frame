<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

interface SessionInterface
{
    /**
     *  @param string  $name
     *  @param array   $data
     *
     *  @return void
     */
    public function __construct($name, array $data = null);

    /**
     *  Get session name prop.
     *
     *  @return string
     */
    public function name();

    /**
     *  Save session with $input set.
     *
     *  @param mixed $input
     *
     *  @return void
     */
    public function update(array $data = null);

    /**
     *  Save session with $input set.
     *
     *  @param mixed $input
     *
     *  @return void
     */
    public function save(array $data = null);

    /**
     *  Remove session.
     *
     *  @param mixed $input
     *
     *  @return void
     */
    public function delete();

    /**
     *  Remove session.
     *
     *  @param mixed $input
     *
     *  @return void
     */
    public function remove();

    /**
     *  Data transfer.
     *
     *  @param mixed $type
     *
     *  @return mixed
     */
    public function enter(callable $call);
}
