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
}
