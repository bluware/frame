<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;


use Frame\Environment\Exception;

/**
 *  Common class for identify environments.
 *
 *  Frame\Config implementation:
 *
 *  {environment}.config.php
 *
 *  Config settings:
 *
 *  "environment" => "production",
 *
 *  Class Environment
 *  @package Frame
 */
class Environment
{
    const ARCH_32BIT = 4;
    const ARCH_64BIT = 8;

    public function __construct(Config $config, $filepath)
    {
        $environment = $config->pull('environment', null);

        if ($environment === null) {
            return;
        }

        $searchFile = sprintf(
            '%s/environments/%s.php', dirname($filepath), $environment
        );

        if (is_file($searchFile) === false) {
            throw new Exception("File ${$searchFile} do not exists.");
        }

        $configurations = include $searchFile;

        if (is_array($configurations) === false) {
            throw new Exception("File ${$searchFile} should return array.");
        }

        $config->data($configurations);
    }

    public static function is32bit()
    {
        return PHP_INT_SIZE === static::ARCH_32BIT;
    }

    public static function is64bit()
    {
        return PHP_INT_SIZE === static::ARCH_64BIT;
    }
}