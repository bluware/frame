<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Database;

use Frame\Data\Writable;
use PDO;
use PDOException;

/**
 * @subpackage Database
 */
abstract class Drive extends Writable
{
    /**
     *  @var \PDO
     */
    protected $pdo;

    /**
     *  @param  mixed $method
     *
     *  @return mixed
     */
    public function pdo($method = null)
    {
        /**
         *  @var boolean
         */
        if ($method === null)
            /**
             *  @var \PDOStatement
             */
            return $this->pdo;

        /**
         *  @var array
         */
        $params = func_get_args();

        /**
         *  @var mixed
         */
        return call_user_func_array([
            $this->pdo,
            array_shift($params)
        ], $params);
    }

    /**
     *  @param  mixed $input
     *  @param  array $bind
     *
     *  @return \Frame\Database\State
     */
    public function query($input, array $bind = null)
    {
        if (is_callable($input) === true) {
            /**
             *  @var Frame\Database\Query
             */
            $query = new Query();

            /**
             *  @var void
             */
            call_user_func($input, $query);

            /**
             *  @var string
             */
            $input = $query->to('string');

            /**
             *  @var array
             */
            $bind  = $query->get('bind');
        }

        /**
         *  @var \PDO
         */
        $pdo = $this->pdo;

        /**
         *  @var \Frame\Database\State
         */
        $state = new State(
            $pdo->prepare($input)
        );

        /**
         *  @var bind
         */
        $state->exec($bind);

        /**
         *  @var \Frame\Database\State
         */
        return $state;
    }

    /**
     *  @param  callable $call
     *  @param  mixed    $error
     *
     *  @return boolean
     */
    public function transaction(callable $call, &$error = null)
    {
        try {
            /**
             *  @var void
             */
            $this->pdo('beginTransaction');

            /**
             *  @var mixed
             */
            $exec = call_user_func($call, $this);

            /**
             *  @var boolean
             */
            if ($exec === false) {
                /**
                 *  @var void
                 */
                $this->pdo('rollBack');

                /**
                 *  @var boolean
                 */
                return false;
            }
        } catch (PDOException $error) {
            /**
             *  @var void
             */
            $this->pdo('rollBack');

            /**
             *  @var boolean
             */
            return false;
        }

        /**
         *  @var void
         */
        $this->pdo('commit');

        /**
         *  @var boolean
         */
        return true;
    }

    /**
     *  @return integer
     */
    public function id()
    {
        /**
         *  @var integer
         */
        return intval(
            $this->pdo('lastInsertId')
        );
    }
}
