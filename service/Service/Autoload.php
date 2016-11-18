<?php

/**
 *  Blu | PHP Lite Web & API Framework
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Service;

use Blu\Data\Writeable;

/**
 * @subpackage Service
 */
class Autoload implements AutoloadInterface
{
    /**
     *  @var \Blu\Data\Writeable
     */
    protected $namespaces;

    /**
     *  @var \Blu\Data\Writeable
     */
    protected $classmaps;

    /**
     *  @return void
     */
    public function __construct()
    {
        /**
         *  @var \Blu\Data\Writeable
         */
        $this->namespaces = new Writeable();

        /**
         *  @var \Blu\Data\Writeable
         */
        $this->classmaps  = new Writeable();
    }

    /**
     * @param string $namespace
     * @param string $dir
     */
    public function add($namespace, $dir)
    {
        $this->namespaces->set(
            $namespace, $dir
        );

        return $this;
    }

    /**
     * @param  array  $classmap
     *
     * @return void
     */
    public function classmap(array $classmap)
    {
        $this->classmap->fill(
            $classmap
        );

        return $this;
    }

    /**
     *  @return void
     */
    public function register()
    {
        spl_autoload_register([
            $this, 'loader'
        ]);

        return $this;
    }

    /**
     *  @param  string $class
     *
     *  @return void
     */
    public function loader($class)
    {
        if ($this->classmaps->has($class) === true) {
            include $this->classmap->get($class);
            return;
        }

        $data = $this->namespaces->data();

        foreach (
            $data as $namespace => $dir
        ) {
            if ($this->prepare(
                $class, $namespace, $dir
            ) === true) {
                return;
            }
        }
    }

    /**
     *  @param  string $class
     *  @param  string $namespace
     *  @param  string $dir
     *
     *  @return boolean
     */
    protected function prepare($class, $namespace, $dir)
    {
        if (substr(
            $class, 0, strlen($namespace)
        ) === $namespace) {
            $class = str_replace([
                $namespace, '\\'
            ], ['', '/'], $class);

            $file = sprintf(
                '%s%s.php', $dir, $class
            );

            if (is_file($file) === true) {
                include($file);
                return true;
            }
        }

        return false;
    }
}
