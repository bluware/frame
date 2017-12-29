<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\Package;

use Frame\App;
use Frame\Data;
use Frame\Package\IRouting;
use Frame\Package\IView;
use Frame\Package\IAutoload;
use Frame\Package\ITranslator;
use Frame\Package\IBootstrap;
use Frame\Package\IHook;

class Dispatcher
{
    /**
     *  @var \Frame\Data\Readable
     */
    protected $directories;

    /**
     *  @var \Frame\Data\Readable
     */
    protected $packages;


    protected $classmap;

    protected $revision = 0;

    /**
     * Dispatcher constructor.
     *
     * @param array|null $packages
     * @param array|null $directories
     */
    public function __construct(
        array $packages = null,
        array $directories = null
    ) {
        /*
         *  @var array
         */
        $this->packages = new Data($packages);

        /*
         *  @var array
         */
        $this->directories = new Data($directories);

        $this->classmap = new Data();
    }

    /**
     * @param array|null $packages
     * @param array|null $directories
     */
    public function add(
        array $packages = null,
        array $directories = null
    ) {
        /*
         *  @var array
         */
        $this->packages->replace($packages);

        /*
         *  @var array
         */
        $this->directories->replace($directories);
    }

    public function exists($name)
    {
        return in_array(
            $name, array_values(
                $this->packages
            ), true
        );
    }

    public function cacheImport($filepath = null)
    {
        if ($filepath === null) {
            $filepath = sprintf('%s/.cache/package.php', getcwd());
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
            $filepath = sprintf('%s/.cache/package.php', getcwd());
        }

        if (is_string($filepath) === false) {
            return $this;
        }

        $directory = dirname($filepath);

        if (is_dir($directory) === false) {
            mkdir($directory, 0755, true);
        }

        $export = sprintf(
            "<?php\n\nreturn %s;\n", var_export($this->classmap->getData(), true)
        );

        file_put_contents($filepath, $export);

        return $this;
    }

    /**
     * @param App $app
     */
    public function dispatch(App $app)
    {
        $packages = [];
        $autoload = $app->_serviceLocator->getService('autoload');

        foreach ($this->packages as $path => $namespace) {
            $isNumeric = is_numeric($path);
            $knowClass = $this->classmap->get($isNumeric ? $namespace : $path, null);
            $directory = null;

            if ($knowClass === null) {
                $classPath = $isNumeric ? str_replace('\\', '/', $namespace) : $path;
                $className = sprintf('%s\\Package', $namespace);

                if (class_exists($className) === false) {
                    $this->browse($className, $path, $directory, $autoload);
                } else {
                    $reflector = new \ReflectionClass($className);
                    $fn = $reflector->getFileName();
                    $directory = dirname($fn);
                }

                $knowClass = [
                    'className' => $className,
                    'classPath' => $directory,
                    'interfaces' => class_implements($className),
                ];

                $this->classmap->set($isNumeric ? $namespace : $path, $knowClass);
            }

            $className = $knowClass['className'];
            $instance  = new $className($app);
            $interfaces = $knowClass['interfaces'];

            /*
             *  @var bool
             */
            if (array_key_exists('Frame\\Package\\ITranslator', $interfaces) === true) {
                /**
                 *  @var \Frame\I18n
                 */
                $i18n = $app->_serviceLocator->getService('translator');

                /**
                 *  @var array
                 */
                $directories = $instance->translator($i18n);

                /*
                 *  @var array
                 */
                if (gettype($directories) === 'array') {
                    /*
                     *  @var iterable
                     */
                    foreach ($directories as $directory) {
                        /*
                         *  @var Frame\Hook\Controller
                         */
                        $i18n->scan($directory);
                    }
                }
            }

            if (array_key_exists('Frame\\Package\\IAutoload', $interfaces) === true) {
                $instance->autoload(
                    $app->_serviceLocator->getService('autoload')
                );
            }

            $knowClass['instance'] = $instance;

            $packages[] = $knowClass;
        }

        /*
         *  Second phase of booting
         */
        foreach ($packages as $package) {
            $instance = $package['instance'];
            $interfaces = $package['interfaces'];
            /*
             *  @var Frame\App
             */
            if (array_key_exists('Frame\\Package\\IBootstrap', $interfaces) === true) {
                $instance->bootstrap(
                    $app->_serviceLocator
                );
            }

            if (array_key_exists('Frame\\Package\\IHook', $interfaces) === true) {
                /**
                 *  @var array
                 */
                $controllers = $instance->hook(
                    $app->_serviceLocator->getService('hook')
                );

                /*
                 *  @var array
                 */
                if (gettype($controllers) === 'array') {
                    /*
                     *  @var iterable
                     */
                    foreach ($controllers as $controller) {
                        /*
                         *  @var Frame\Hook\Controller
                         */
                        new $controller($app);
                    }
                }
            }

            if (array_key_exists('Frame\\Package\\IRouting', $interfaces) === true) {
                $instance->routing(
                    $app->_serviceLocator->getService('router')
                );
            }

            if (array_key_exists('Frame\\Package\\IView', $interfaces) === true) {
                $instance->view(
                    $app->_serviceLocator->getService('view')
                );
            }
        }
    }

    protected function __namespace($class)
    {
        $path = explode(
            '\\', $class
        );

        return array_pop(
            $class
        );
    }

    /**
     *  @return void
     */
    public function browse($package, $path, &$_directory, \Frame\Autoload $autoload)
    {
        foreach ($this->directories as $directory) {
            $directory = sprintf(
                '%s/%s', $directory, $path
            );

            $file = sprintf(
                '%s/Package.php', $directory
            );

            if (is_file($file) === true) {
                include_once $file;
                $autoload->classmap([$package => $file]);

                $_directory = $directory;

                return;
            }
        }
    }
}
