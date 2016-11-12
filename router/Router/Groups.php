<?php

/**
 *  PHP Lite Frame
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Router;

use Blu\Data\Writeable;
use Blu\Data\Readable;

/**
 * @subpackage Router
 */
class Groups extends Writeable
{
    /**
     *  @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    /**
     *  @param  mixed $data
     *
     *  @return void
     */
    public function change($data)
    {
        /**
         *  @var array
         */
        $data = new Readable(is_array($data) ? $data : [
            'namespace' => $data
        ]);

        /**
         *  @var array
         */
        foreach (['aspect', 'aspects', 'middleware'] as $name) {

            $aspects = $data->get($name);

            if ($aspects !== null) {
                $current = $this->get('aspects', []);

                $this->set('aspects', array_replace(
                    $current, is_array($aspects) ?
                        $aspects : [$aspects]
                ));
            }
        }

        $namespace = $data->get('namespace');

        /**
         *  @var string
         */
        if ($namespace !== null) {
            $this->set('namespace', sprintf(
                '%s\\%s',
                $this->get('namespace'),
                $namespace
            ));
        }

        return $this;
    }

    /**
     *  @param  array  $data
     *
     *  @return void
     */
    public function revert(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     *  @return void
     */
    public function clean()
    {
        $this->data = [];

        return $this;
    }
}
