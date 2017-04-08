<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

class Dir
{
    /**
     *  @param $path
     *
     *  @return bool
     */
    public static function exists($path)
    {
        return is_dir($path);
    }

    /**
     *  @param $path
     *
     *  @return bool
     */
    public static function is($path)
    {
        return is_dir($path);
    }

    /**
     *  @param $path
     *
     *  @return string
     */
    public static function name($path)
    {
        return dirname($path);
    }

    /**
     *  @param  string  $path
     *  @param  int $mode
     *  @param  bool    $recursive
     *
     *  @return bool
     */
    public static function make(
        $path, $mode = 0755, $recursive = true
    ) {
        if (is_dir($path) === false) {
            return mkdir(
                $path, $mode, $recursive
            );
        }

        return true;
    }

    /**
     *  @param  string  $path
     *  @param  int $mode
     *  @param  bool    $recursive
     *
     *  @return bool
     */
    public static function mk(
        $path, $mode = 0755, $recursive = true
    ) {
        if (is_dir($path) === false) {
            return mkdir(
                $path, $mode, $recursive
            );
        }

        return true;
    }

    /**
     *  @param  string $path
     *
     *  @return bool
     */
    public static function remove($path)
    {
        return rmdir($path);
    }

    /**
     *  @param  string $path
     *
     *  @return bool
     */
    public static function rm($path)
    {
        return rmdir($path);
    }
}
