<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Database\Adapter;

use Frame\Database\Adapter;
use PDO;

class PgSQL extends Adapter
{
    /**
     *  @param array $data
     */
    public function __construct(array $data)
    {
        /*
         *  @var array
         */
        $this->data = $data;

        /**
         * @var string
         */
        $connect = $this->has('unix_socket') ?
            sprintf(
                'unix_socket=%s',
                $this->get('unix_socket')
            ) : sprintf(
                'host=%s;port=%s',
                $this->get('host', '127.0.0.1'),
                $this->get('port', 5432)
            );

        /*
         *  @var PDO
         */
        $this->pdo = new PDO(
            sprintf(
                'pgsql:%s;dbname=%s',
                $connect,
                $this->get('dbname')
            ),
            $this->get('username'),
            $this->get('password'),
            $this->get(
                'options', []
            )
        );

        /*
         *  @var void
         */
        $this->pdo(
            'setAttribute',
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        /*
         *  @var void
         */
        $this->pdo(
            'exec', strtoupper(
                sprintf(
                    "SET NAMES '%s'",
                    $this->get('charset', 'utf8')
                )
            )
        );
    }
}
