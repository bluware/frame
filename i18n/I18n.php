<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Data;

/**
 * @subpackage Package
 */
class I18n
{
    protected $file = false;

    protected $meta = [];

    protected $data = [];


    protected function unpack($bytes, $ed = false)
    {
        return unpack(
            sprintf(
                '%s%d', $ed === false ? 'V' : 'N', $bytes
            ), fread(
                $this->file, 4 * $bytes
            )
        );
    }


    public function read($path, $locale, array $options = array())
    {
        $this->data = [];

        $ed = false;

        $this->file = @fopen(
            $path, 'rb'
        );

        if ($this->file === false)
            throw new \Exception("No file");

        if (@filesize($path) < 10) {
            @fclose($this->file);

            throw new \Exception('\'' . $path . '\' is not a gettext file');
        }

        $input = $this->unpack(1, $ed);

        $ed = strtolower(
            substr(
                dechex($input[1]), -8
            )
        );

        if ($ed !== '950412de' && $ed !== 'de120495') {
            @fclose($this->file);

            throw new \Exception('\'' . $path . '\' is not a gettext file');
        }

        $ed = $ed === 'de120495';

        // read revision - not supported for now
        $input  = $this->unpack(
            1, $ed
        );

        // number of bytes
        $input  = $this->unpack(
            1, $ed
        );

        $total  = $input[1];

        // number of original strings
        $input  = $this->unpack(
            1, $ed
        );

        $OOffset = $input[1];
        // number of translation strings
        $input  = $this->unpack(
            1, $ed
        );

        $TOffset = $input[1];

        // fill the original table
        fseek(
            $this->file, $OOffset
        );

        $origtemp = $this->unpack(
            2 * $total, $ed
        );

        fseek(
            $this->file, $TOffset
        );

        $transtemp = $this->unpack(
            2 * $total, $ed
        );

        for($count = 0; $count < $total; ++$count) {
            if ($origtemp[$count * 2 + 1] != 0) {

                fseek(
                    $this->file, $origtemp[$count * 2 + 2]
                );

                $original = @fread($this->file, $origtemp[$count * 2 + 1]);
                $original = explode("\0", $original);
            } else {
                $original[0] = '';
            }

            if ($transtemp[$count * 2 + 1] != 0) {
                fseek(
                    $this->file,
                    $transtemp[$count * 2 + 2]
                );

                $translate = fread(
                    $this->file,
                    $transtemp[$count * 2 + 1]
                );

                $translate = explode(
                    "\0", $translate
                );

                if (count($original) > 1) {
                    $this->data[$locale][$original[0]] = $translate;

                    array_shift($original);

                    foreach ($original as $orig)
                        $this->data[$locale][$orig] = '';

                } else {
                    $this->data[$locale][$original[0]] = $translate[0];
                }
            }
        }

        @fclose($this->file);

        $this->data[$locale][''] = trim(
            $this->data[$locale]['']
        );

        $this->meta[$path] = isset(
            $this->data[$locale]['']
        ) ? $this->data[$locale][''] : 'No meta';

        unset(
            $this->data[$locale]['']
        );

        return $this->data;
    }

    public function meta()
    {
        return $this->meta;
    }
}
