<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Data\Readable;
use Frame\Form;

/**
 * @subpackage Session
 */
class Paging extends Form
{
    /**
     *  @param string  $name
     *  @param array   $data
     *
     *  @return void
     */
    public function __construct($total = 0, Readable $q = null)
    {
        $this->input(
            'total', 0
        )->filter([
            'integer'
        ])->set(
            $total
        );

        $this->input(
            'limit', 10
        )->filter([
            'integer', 'enum' => [
                5, 10, 25
            ]
        ]);

        $this->input(
            'let', 0
        )->filter([
            'integer'
        ]);

        $this->input(
            'offset', 0
        )->filter([
            'integer', 'cast' => function(&$value) {
                $page = $this->get('page') - 1;

                $value = $page * $this->get('limit');

                $value += $this->get('let');

                return true;
            }
        ]);

        $this->input(
            'pages', 0
        )->filter([
            'integer', 'min' => function(&$value) {
                $value = intval(
                    ceil(
                        $this->get('total') / $this->get('limit')
                    )
                );

                return true;
            }
        ]);

        $this->input(
            'page', 1
        )->filter([
            'integer', 'between' => function(&$value) {
                if ($value < 0)
                    $value = 1;

                $pages = $this->get('pages');

                if ($pages > 0 && $value > $pages)
                    $value = $pages;

                return true;
            }
        ]);

        if ($q !== null)
            $this->apply($q);
    }
}
