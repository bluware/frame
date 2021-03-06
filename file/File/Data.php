<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame\File;

class Data extends \Frame\Data
{
    /**
     *  @param  string $data
     *
     *  @return void
     */
    public function __construct($data)
    {
        if (gettype($data) !== 'array') {
            throw new \Exception(
                "Bad constructor data type. Need 'array'"
            );
        }

        if (array_key_exists('tmp_name', $data) === true) {
            $data['file'] = $data['tmp_name'];
        }

        $diff = array_intersect(
            array_keys($data), [
                'file',
                'type',
                'name',
                'size',
            ]
        );

        if (count($diff) !== 4) {
            throw new \Exception(
                "Missed key in 'file', 'type', 'name' or 'size'"
            );
        }

        foreach ($data as $input => $value) {
            $this->set($input, $value);
        }
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

        if ($filesystem === false || $filesystem === null) {
            return file_put_contents(
                $file, $this->get('file')
            );
        }

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
