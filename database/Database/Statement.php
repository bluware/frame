<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Database;

use PDO;
use PDOStatement;

/**
 * @subpackage Database
 */
class Statement
{
    /**
     *  @var \PDOStatement
     */
    protected $state;

    /**
     *  @var bool
     */
    protected $exec;

    /**
     *  State constructor.
     *
     *  @param PDOStatement $statement
     *  @param bool $exec
     */
    public function __construct(PDOStatement $statement, $exec = false)
    {
        /**
         *  @var \PDOStatement
         */
        $this->state = $statement;

        /**
         *  @var boolean
         */
        $this->exec  = $exec;
    }

    /**
     *  @param  string $method
     *
     *  @return mixed
     */
    public function state($method = null)
    {
        /**
         *  @var boolean
         */
        if ($method === null)
            /**
             *  @var \PDOStatement
             */
            return $this->state;

        /**
         *  @var array
         */
        $params = func_get_args();

        /**
         *  @var mixed
         */
        return call_user_func_array([
            $this->state,
            array_shift($params)
        ], $params);
    }


    /**
     *  @param  string $input
     *  @return mixed
     */
    public function one($input = null)
    {
        /**
         *  @var array
         */
        $data = $this->state(
            'fetch', PDO::FETCH_ASSOC
        );

        if ($data === false)
            $data = [];

        /**
         *  @var mixed
         */
        if ($input !== null)
            /**
             *  @var mixed
             */
            return array_key_exists($input, $data) ?
                $data[$input] : null;

        /**
         *  @var array
         */
        return $data;
    }

    /**
     *  @param  string $input
     *  @param  string $index
     *
     *  @return mixed
     */
    public function all($input = null, $index = null)
    {
        /**
         *  @var array
         */
        $data = $this->state('fetchAll', PDO::FETCH_ASSOC);

        /**
         *  @var array
         */
        if ($data === false)
            $data = [];

        /**
         *  @var array
         */
        if ($input !== null && sizeof($data) > 0)
            /**
             *  @var array
             */
            return array_key_exists($input, $data[0]) ?
                array_column($data, $input, $index) : [];

        /**
         *  @var array
         */
        return $data;
    }

    /**
     *  @return integer
     */
    public function count()
    {
        return $this->state('rowCount');
    }

    /**
     *  @param  array $bind
     *
     *  @return static
     */
    public function exec(array $bind = null)
    {
        if ($this->exec === false) {
            /**
             *  @var boolean
             */
            if ($bind !== null) {
                /**
                 *  @var void
                 */
                foreach ($bind as $input => $value) {
                    $this->state->bindParam(
                        $input + 1, $value
                    );
                    
//                    /**
//                     *  @var integer
//                     */
//                    $hold = is_numeric(
//                        $value
//                    ) && is_integer(
//                        $value + 0
//                    ) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
//
//                    /**
//                     *  @var void
//                     */
//                    $this->state(
//                        'bindValue',
//                        $input,
//                        $value,
//                        $hold
//                    );
                }
            }


            /**
             *  @var void
             */
            $this->state('execute');

            /**
             *  @var boolean
             */
            $this->exec = true;
        }

        /**
         *  @var static
         */
        return $this;
    }
}
