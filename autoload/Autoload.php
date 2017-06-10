<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

class Autoload
{
    /**
     *  @var \Frame\Data
     */
    protected $namespaces;

    /**
     *  @var \Frame\Data
     */
    protected $classmap;

    /**
     *  @var \Frame\Data
     */
    protected $revision = 0;

    public function __construct()
    {
        /*
         *  @var \Frame\Data
         */
        $this->namespaces = new Data();

        /*
         *  @var \Frame\Data\Data
         */
        $this->classmap = new Data();

        /*
         *  @var \Frame\Data\Data
         */
        spl_autoload_register([
            $this, 'loader',
        ]);
    }

    public function cacheImport($filepath = null)
    {
        if ($filepath === null) {
            $filepath = sprintf('%s/.cache/autoload.php', getcwd());
        }

        if (is_string($filepath) === false) {
            return $this;
        }

        $classmap = is_file($filepath) ? include $filepath : [];

        if (is_array($filepath) === true) {
            $this->classmap->setData($classmap);
        }

        $this->revision = $this->classmap->count();

        return $this;
    }

    public function cacheExport($filepath = null)
    {
        if ($this->classmap->count() === $this->revision) {
            return $this;
        }

        if ($filepath === null) {
            $filepath = sprintf('%s/.cache/autoload.php', getcwd());
        }

        if (is_string($filepath) === false) {
            return $this;
        }

        $directory = dirname($filepath);

        if (is_dir($directory) === false) {
            mkdir($directory, 0755, true);
        }

        $export = sprintf(
            "<?php\n\nreturn %s;", var_export($this->classmap->getData(), true)
        );

        file_put_contents($filepath, $export);

        return $this;
    }

    /**
     * @param string $namespace
     * @param string $dir
     *
     * @return $this
     */
    public function add($namespace, $dir)
    {
        $this->namespaces->set(
            $namespace, $dir
        );

        return $this;
    }

    /**
     * @param array $classmap
     *
     * @return $this
     */
    public function classmap(array $classmap)
    {
        $this->classmap->setData(
            $classmap
        );

        return $this;
    }

    /**
     *  @param  string $class
     *
     *  @return void
     */
    public function loader($class)
    {
        if ($this->classmap->has($class) === true) {
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
     *  @return bool
     */
    protected function prepare($class, $namespace, $dir)
    {
        if (substr(
            $class, 0, strlen($namespace)
        ) === $namespace) {
            $classpath = str_replace([
                $namespace, '\\',
            ], ['', '/'], $class);

            $file = sprintf(
                '%s%s.php', $dir, $classpath
            );

            if (is_file($file) === true) {
                include $file;
                $this->classmap->set($class, $file);

                return true;
            }
        }

        return false;
    }
}
