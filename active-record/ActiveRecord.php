<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\ActiveRecord\Query;

abstract class ActiveRecord extends Query
{
    /**
     *  @param  array  $data
     *
     *  @return mixed
     */
    public static function create(array $data)
    {
        return (new static())->insert(
            $data
        );
    }

    /**
     *  @param  scalar $id
     *
     *  @return mixed
     */
    public static function find($id)
    {
        return (new static())->select(
            'one', function (
                $q, $self
            ) use ($id) {
                /**
                 *  @var bool
                 */
                $primary = is_scalar($self->primary);

                /*
                 *  @var boolean
                 */
                if ($primary === false) {
                    throw new \Exception(
                        'Bad primary implementation'
                    );
                }

                /*
                 *  @var boolean
                 */
                $q->where([
                    $self->primary => $id,
                ])->limit(
                    1, 0
                );
            }
        );
    }

    /**
     *  @param  mixed   $where
     *  @param  mixed   $order
     *  @param  int $offset
     *
     *  @return mixed
     */
    public static function one(
        $where = null,
        $order = null,
        $offset = null
    ) {
        if (gettype($where) === 'string' && $where === 'query') {
            return (new static())->select('one', $order);
        }

        return (new static())->select(
            'one', function (
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
     *  @param  int $limit
     *  @param  int $offset
     *
     *  @return mixed
     */
    public static function by(
        $where = null,
        $order = null,
        $limit = null,
        $offset = null
    ) {
        if (gettype($where) === 'string' && $where === 'query') {
            return (new static())->select('all', $order);
        }

        return (new static())->select(
            'all', function (
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
     *  @param int $limit
     *  @param int $offset
     *
     *  @return mixed
     */
    public static function first($limit = 1, $offset = 0)
    {
        return (new static())->select($limit <= 1 ? 'one' : 'all', function (
            $q, $self
        ) use (
            $limit, $offset
        ) {
            /**
             *  @var bool
             */
            $primary = is_scalar($self->primary);

            /*
             *  @var boolean
             */
            if ($primary === false) {
                throw new \Exception(
                    'Bad primary implementation'
                );
            }

            /*
             *  @var boolean
             */
            $q->order(
                $self->primary, 'asc'
            )->limit(
                $limit, $offset
            );
        });
    }

    /**
     *  @param int $limit
     *  @param int $offset
     *
     *  @return mixed
     */
    public static function last($limit = 1, $offset = 0)
    {
        return (new static())->select($limit <= 1 ? 'one' : 'all', function (
            $q, $self
        ) use (
            $limit, $offset
        ) {
            /**
             *  @var bool
             */
            $primary = is_scalar($self->primary);

            /*
             *  @var boolean
             */
            if ($primary === false) {
                throw new \Exception(
                    'Bad primary implementation'
                );
            }

            /*
             *  @var boolean
             */
            $q->order(
                $self->primary, 'desc'
            )->limit(
                $limit, $offset
            );
        });
    }

    /**
     *  @param $keys
     *
     *  @return mixed
     */
    public static function in(
        $keys,
        $order = null,
        $limit = null,
        $offset = null
    ) {
        if (gettype($keys) === 'string' && $keys === 'query') {
            return (new static())->select('all', $order);
        }

        if (gettype($keys) !== 'array' && is_callable($keys) === false) {
            $keys = func_get_args();
        }

        return (new static())->select(
            'all', function (
                $q, $self
            ) use (
                $keys,
                $order,
                $limit,
                $offset
            ) {
                if (is_callable($keys) === true) {
                    /*
                     *  @var boolean
                     */
                    call_user_func(
                        $where, $q
                    );
                } else {
                    /**
                     *  @var bool
                     */
                    $primary = is_scalar($self->primary);

                    /*
                     *  @var boolean
                     */
                    if ($primary === false) {
                        throw new \Exception(
                            'Bad primary implementation'
                        );
                    }

                    $q->where(
                        $self->primary, 'in', $keys
                    );
                }

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
        /*
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
