<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\ActiveRecord\Query;

/**
 * @subpackage Active
 */
abstract class ActiveRecord extends Query
{
    /**
     *  @param  array  $data
     *  @return mixed
     */
    public static function create(array $data)
    {
        return (new static)->insert(
            $data
        );
    }

    /**
     *  @param  scalar $id
     *  @return mixed
     */
    public static function find($id)
    {
        return (new static)->select(
            'one', function(
                $q, $self
            ) use ($id) {
                /**
                 *  @var boolean
                 */
                $primary = is_scalar($self->primary);

                /**
                 *  @var boolean
                 */
                if ($primary === false)
                    throw new \Exception(
                        "Bad primary implementation"
                    );

                /**
                 *  @var boolean
                 */
                $q->where([
                    $self->primary
                        => $id
                ])->limit(
                    1, 0
                );
            }
        );
    }

    /**
     *  @param  mixed   $where
     *  @param  mixed   $order
     *  @param  integer $offset
     *
     *  @return mixed
     */
    public static function one(
        $where  = null,
        $order  = null,
        $offset = null
    ) {
        if (gettype($where) === 'string' && $where === 'query')
            return (new static)->query('one', $order);

        return (new static)->select(
            'one', function(
                $q, $self
            ) use (
                $where,
                $order,
                $offset
            ) {
                is_callable(
                    $where
                ) ? call_user_func(
                    $where, $q
                ) : $q->where(
                    $where
                );

                $q->order(
                    $order
                )->limit(
                    1,
                    $offset
                );
            }
        );
    }

    /**
     *  @param  mixed   $where
     *  @param  mixed   $order
     *  @param  integer $limit
     *  @param  integer $offset
     *
     *  @return mixed
     */
    public static function by(
        $where  = null,
        $order  = null,
        $limit  = null,
        $offset = null
    ) {
        if (gettype($where) === 'string' && $where === 'query')
            return (new static)->query('all', $order);

        return (new static)->select(
            'all', function(
                $q, $self
            ) use (
                $where,
                $order,
                $limit,
                $offset
            ) {
                is_callable(
                    $where
                ) ? call_user_func(
                    $where, $q
                ) : $q->where(
                    $where
                );

                $q->order(
                    $order
                )->limit(
                    $limit,
                    $offset
                );
            }
        );
    }

    /**
     *  @return mixed
     */
    public static function all()
    {
        return (
            new static()
        )->select(
            'all'
        );
    }

    /**
     *  @param  array $data
     *
     *  @return static
     */
    public function save(array $data = null)
    {
        /**
         *  @var static
         */
        return $this->{
            $this->isset === true ?
                'update' : 'insert'
        }($data);
    }

    /**
     *  @return mixed
     */
    public function remove()
    {
        return $this->delete();
    }
}
