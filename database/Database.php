<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Database\Union;

/**
 * @subpackage Database
 */
class Database
{
    /**
     *  @const MySQL
     */
    const MySQL     = 'mysql';

    /**
     *  @const PgSQL
     */
    const PgSQL     = 'pgsql';

    /**
     *  @const SQLite
     */
    const SQLite    = 'sqlite';

    /**
     *  @return \Frame\Database\Union
     */
    public static function union()
    {
        /**
         *  @var mixed
         */
        static $union = null;

        /**
         *  @var boolean
         */
        if ($union === null)
            /**
             *  @var \Frame\Database\Union
             */
            $union = new Union;

        /**
         *  @var \Frame\Database\Union
         */
        return $union;
    }
}
