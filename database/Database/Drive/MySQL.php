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
class MySQL extends Drive
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

        /**
         * @var string
         */
        $connect = $this->has('unix_socket') ?
            sprintf(
                'unix_socket=%s',
                $this->get(
                    'unix_socket',
                    '/var/lib/mysql/mysql.sock'
                )
            ) : sprintf(
                'host=%s;port=%s',
                $this->get('host', '127.0.0.1'),
                $this->get('port', 3306)
            );

        /**
         *  @var PDO
         */
        $this->pdo = new PDO(
            sprintf(
                'mysql:%s;dbname=%s',
                $connect,
                $this->get('dbname')
            ),
            $this->get('username'),
            $this->get('password'),
            [
                PDO::ATTR_PERSISTENT => true
            ]
        );

        /**
         *  @var void
         */
        $this->pdo(
            'setAttribute',
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        /**
         *  @var void
         */
        $this->pdo(
            'exec', sprintf(
                "SET NAMES %s",
                $this->get('charset', 'utf8')
            )
        );
    }
}
