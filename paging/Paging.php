<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Http\Request\Query;
use Frame\Data\Writable;

/**
 * @subpackage Session
 */
class Paging extends Writable
{
    /**
     *  @var \Frame\Http\Request\Query
     */
    protected $q;

    /**
     *  @param string  $name
     *  @param array   $data
     *
     *  @return void
     */
    public function __construct(Query $q, $all = 0)
    {
        $this->replace([
            'page.this'
                => 1,
            'let'
                => 0,
            'max'
                => 25,
        ])->replace(
            $q->to('array')
        )->([
            'all'
                => $all,
        ]);

        $this->set(
            'page.count', intval(
                ceil(
                    $all / $this->get('max')
                )
            )
        );

        if ($this->get('page', 1) < 1)
            $this->set(
                'page', 1
            );

        $this->set('off')

        if ($this->get('all', 0) === 0)
    }
}
