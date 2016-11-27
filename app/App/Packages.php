<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\App;

use Frame\Data;
use Frame\App;

/**
 * @subpackage App
 */
class Packages
{
    /**
     *  @var \Frame\Data\Readable
     */
    protected $directories;

    /**
     *  @var \Frame\Data\Readable
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
        $this->packages     = new Data($packages);

        /**
         *  @var array
         */
        $this->directories  = new Data($directories);
    }

    /**
     *  @return void
     */
    public function add(
        array $packages     = null,
        array $directories  = null
    ) {
        /**
         *  @var array
         */
        $this->packages->replace($packages);

        /**
         *  @var array
         */
        $this->directories->replace($directories);
    }

    /**
     *  @return void
     */
    public function dispatch(App $app)
    {
        foreach ($this->packages as $path => $namespace) {
            if (is_numeric($path) === true)
                $path = str_replace('\\', '/', $namespace);

            $package = sprintf('%s\\Package', $namespace);

            class_exists($package) === false ?
                $this->browse($path) : null;

            new $package($app);
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
