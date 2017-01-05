<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\File;

/**
 *  @subpackage File
 */
class Data extends \Frame\Data
{
    /**
     *  @param  string $data
     *
     *  @return void
     */
    public function __construct($data)
    {
        if (gettype($data) !== 'array')
            throw new \Exception(
                "Bad constructor data type. Need 'array'"
            );

        $diff = array_diff(
            array_keys($data), [
                'file',
                'type',
                'name',
                'size'
            ]
        );

        if (sizeof($diff) > 0)
            throw new \Exception(
                "Missed key in 'file', 'type', 'name' or 'size'"
            );

        foreach ($data as $input => $value)
            $this->set($input, $value);
    }

    /**
     *  @param  string $file
     *
     *  @return void
     */
    public function put($file, $command = 'mv')
    {
        $filesystem = @is_file(
            $this->get('file')
        );

        if ($filesystem === false || $filesystem === null)
            return file_put_contents(
                $file, $this->get('file')
            );

        switch ($command) {
            case 'mv': case 'move':
                rename(
                    $this->get('file'), $file
                );
                break;

            case 'cp': case 'copy':
                copy(
                    $this->get('file'), $file
                );
                break;
        }
    }
}
