<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Database;

use Frame\Data\Write;

use Frame\Database\Query\Where;

/**
 * @subpackage Database
 */
class Query
{
    /**
     *  @var string
     */
    protected $state = 'select';

    /**
     *  @var string
     */
    protected $table;

    /**
     *  @var array
     */
    protected $where;

    /**
     *  @var array
     */
    protected $having;

    /**
     *  @var \Frame\Data\Write
     */
    protected $bind;

    /**
     *  @return void
     */
    public function __construct()
    {
        /**
         *  @var \Frame\Data\Write
         */
        $this->where    = new Where();

        /**
         *  @var \Frame\Data\Write
         */
        $this->having   = new Where();

        /**
         *  @var \Frame\Data\Write
         */
        $this->bind     = new Write();
    }

    public function and($clause)
    {
        $this->{$clause}->and();

        $params = func_get_args();

        if (sizeof($params) === 1)
            return $this;

        return call_user_func_array([
            $this, array_shift($params)
        ], $params);
    }

    /**
     *  @param  [type] $clause [description]
     *
     *  @return void
     */
    public function or($clause)
    {
        $this->{$clause}->or();

        $params = func_get_args();

        if (sizeof($params) === 1)
            return $this;

        return call_user_func_array([
            $this, array_shift($params)
        ], $params);
    }

    public function where($data)
    {
        $params = func_get_args();

        array_unshift($params, 'where');

        return call_user_func_array([
            $this, '__where'
        ], $params);
    }

    public function having($data)
    {
        $params = func_get_args();

        array_unshift($params, 'having');

        return call_user_func_array([
            $this, '__where'
        ], $params);
    }

    /**
     *  @return void
     */
    protected function __where($prop, $data)
    {
        $params = func_get_args();

        array_shift($params);

        if (sizeof($params) === 1) {
            if (gettype($data) === 'string') {
                $this->where->push($data);
            }

            if (gettype($data) === 'array') {
                foreach ($data as $column => $value) {
                    is_numeric($column) ? $this->where->push(
                        $value
                    ) : $this->where->add(
                            $column,
                            '=',
                            $this->bind(
                                $column,
                                $value
                            )
                        );
                }
            }

            if (gettype($data) === 'object') {
                $this->where->detach(
                    $this, $data
                );
            }
        }

        if (sizeof($params) === 2) {
            $this->where->add(
                $params[0],
                '=',
                $this->bind(
                    $params[0],
                    $params[1]
                ),
                'and'
            );
        }

        if (sizeof($params) === 3) {
            $this->where->add(
                $params[0],
                $params[1],
                $this->bind(
                    $params[0],
                    $params[2]
                ),
                'and'
            );
        }

        if (sizeof($params) === 4) {
            $this->where->add(
                $params[0],
                $params[1],
                $this->bind(
                    $params[0],
                    $params[2]
                ),
                $params[3]
            );
        }

        return $this;
    }

    /**
     *  @return void
     */
    public function bind($column, $val)
    {
        if (gettype($val) === 'array')
            return $val;

        if ($val === null) return 'NULL';

        $mock = sprintf(
            ':%s:%s:%s',
            $column,
            rand(10000,99999),
            uniqid()
        );

        $this->bind->set($mock, $val);

        return $mock;
    }

    public function to()
    {
        return $this->where->to('string');
    }
}
