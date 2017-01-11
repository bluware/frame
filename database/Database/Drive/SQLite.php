<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Database\Drive;

use Frame\Database\Drive;
use PDO;

/**
 * @subpackage Database
 */
class SQLite extends Drive
{
    /**
     *  @param array $data
     */
    public function __construct(array $data)
    {
        /**
         *  @var array
         */
        $this->data = $data;

        $dsn = $this->dsn([
            'path' => ':memory:'
        ], $data);

        /**
         *  @var string
         */
        $path = $this->get('path', ':memory:');

        /**
         *  @var PDO
         */
        $this->pdo = new PDO(
            sprintf('sqlite:%s', $path),
            null,
            null,
            $this->get(
                'options', []
            )
        );

        /**
         *  @var void
         */
        $this->pdo(
            'setAttribute',
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }
}
