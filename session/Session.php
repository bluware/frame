<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Session\Exception;
use Frame\Data\Writable;

/**
 * @subpackage Session
 */
class Session extends Writable implements SessionInterface
{
    /**
     *  @var string
     */
    protected $name             = 'frame.session';

    /**
     *  @var string
     */
    protected $data;

    /**
     *  @param string  $name
     *  @param array   $data
     *
     *  @return void
     */
    public function __construct($name, array $data = null, $id = null) {
        /**
         *  @var string
         */
        $this->name  = $name;

        /**
         *  @var array
         */
        $this->data  = $data;

        /**
         *  @var boolean
         */
        if ($data === null)
            /**
             *  @var array
             */
            $this->enter(function() use ($data) {
                /**
                 *  @var bool
                 */
                $exist = array_key_exists(
                    $this->name, $_SESSION
                );

                /**
                 *  @var bool
                 */
                if ($exist === true)
                    /**
                     *  @var mixed
                     */
                    $data = $_SESSION[$this->name];

                /**
                 *  @var bool
                 */
                if (gettype($data) !== 'array')
                    /**
                     *  @var array
                     */
                    $data = [];

                /**
                 *  @var mixed
                 */
                $this->data = $data;
            });

        if ($id !== null)
            session_id($sid);
    }

    /**
     *  Get session name prop.
     *
     *  @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     *  Save session with $input set.
     *
     *  @param mixed $input
     *
     *  @return void
     */
    public function update(array $data = null)
    {
        if ($data !== null)
            $this->data($data);

        $this->enter(function() {
            $_SESSION[$this->name] = $this->data;
        });

        return $this;
    }

    /**
     *  Save session with $input set.
     *
     *  @param mixed $input
     *
     *  @return void
     */
    public function save(array $data = null)
    {
        return $this->update($data);
    }

    /**
     *  Remove session.
     *
     *  @param mixed $input
     *
     *  @return void
     */
    public function delete()
    {
        $this->enter(function() {
            if (array_key_exists($this->name, $_SESSION) === true)
                unset($_SESSION[$this->name]);
        });

        return $this;
    }

    /**
     *  Remove session.
     *
     *  @param mixed $input
     *
     *  @return void
     */
    public function remove()
    {
        return $this->delete();
    }

    /**
     *  Data transfer.
     *
     *  @param mixed $type
     *
     *  @return mixed
     */
    public function enter(callable $call)
    {
        /**
         *  @var void
         */
        session_start();

        /**
         *  @var void
         */
        call_user_func($call);

        /**
         *  @var void
         */
        session_commit();

        /**
         *  @var $this
         */
        return $this;
    }
}
