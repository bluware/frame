<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\Service;

use Frame\Data;

/**
 * @subpackage Service
 */
class Autoload
{
    /**
     *  @var \Frame\Data
     */
    protected $namespaces;

    /**
     *  @var \Frame\Data
     */
    protected $classmaps;

    /**
     *  @return void
     */
    public function __construct()
    {
        /**
         *  @var \Frame\Data
         */
        $this->namespaces = new Data();

        /**
         *  @var \Frame\Data\Data
         */
        $this->classmaps  = new Data();

        /**
         *  @var \Frame\Data\Data
         */
        spl_autoload_register([
            $this, 'loader'
        ]);
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

    // /**
    //  *  @return void
    //  */
    // public function register()
    // {
    //     spl_autoload_register([
    //         $this, 'loader'
    //     ]);
    //
    //     return $this;
    // }

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
