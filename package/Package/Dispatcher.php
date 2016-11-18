<?php

/**
 *  Blu PHP Lite & Scaleable Web Frame
 *
 *  @package  Blu
 *  @author   Eugen Melnychenko
 */
namespace Blu\Package;

use Blu\Data\Readable;

/**
 * @subpackage Package
 */
class Dispatcher implements DispatcherInterface
{
    /**
     *  @var \Blu\Data\Readable
     */
    protected $directories;

    /**
     *  @var \Blu\Data\Readable
     */
    protected $packages;

    /**
     *  @return void
     */
    public function __construct(
        array $packages     = null,
        array $directories  = null
    ) {
        /**
         *  @var array
         */
        $this->packages     = new Readable($packages);

        /**
         *  @var array
         */
        $this->directories  = new Readable($directories);
    }

    /**
     *  @return void
     */
    public function dispatch()
    {
        foreach ($this->packages as $path => $namespace) {
            if (is_numeric($path) === true)
                $path = str_replace('\\', '/', $namespace);

            $package = sprintf('%s\\Package', $namespace);

            class_exists($package) === false ?
                $this->browse($path) : null;

            new $package();
        }
    }

    /**
     *  @return void
     */
    public function browse($path)
    {
        foreach ($this->directories as $directory) {
            $file = sprintf(
                '%s/%s/Package.php',
                $directory,
                $path
            );

            is_file($file) ?
                include($file) : null;
        }
    }
}
