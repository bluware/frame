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
    // Internal variables
    private $dian   = false;
    private $file        = false;
    private $meta = array();
    private $data        = array();
    /**
     * Read values from the MO file
     *
     * @param  string  $bytes
     */
    protected function unpack($bytes)
    {
        return unpack(
            sprintf(
                '%s%d', $this->dian === false ? 'V' : 'N', $bytes
            ), fread(
                $this->file, 4 * $bytes
            )
        );
    }
    /**
     * Load translation data (MO file reader)
     *
     * @param  string  $path  MO file to add, full path must be given for access
     * @param  string  $locale    New Locale/Language to set, identical with locale identifier,
     *                            see Zend_Locale for more information
     * @param  array   $option    OPTIONAL Options to use
     * @throws Zend_Translation_Exception
     * @return array
     */
    public function read($path, $locale, array $options = array())
    {
        $this->data = [];

        $this->dian = false;

        $this->file = @fopen(
            $path, 'rb'
        );

        if ($this->file === false)
            throw new \Exception("No file");

        if (@filesize($path) < 10) {
            @fclose($this->file);

            throw new \Exception('\'' . $path . '\' is not a gettext file');
        }

        // get Endian
        $input = $this->unpack(1);

        $dian = strtolower(
            substr(
                dechex($input[1]), -8
            )
        );

        if ($dian !== '950412de' && $dian !== 'de120495') {
            @fclose($this->file);
            // require_once 'Zend/Translate/Exception.php';
            throw new \Exception('\'' . $path . '\' is not a gettext file');
        }

        if ($dian === 'de120495')
            $this->dian = true;

        // read revision - not supported for now
        $input  = $this->unpack(1);

        // number of bytes
        $input  = $this->unpack(1);

        $total  = $input[1];

        // number of original strings
        $input  = $this->unpack(1);

        $OOffset = $input[1];
        // number of translation strings
        $input  = $this->unpack(1);

        $TOffset = $input[1];

        // fill the original table
        fseek(
            $this->file, $OOffset
        );

        $origtemp = $this->unpack(
            2 * $total
        );

        fseek(
            $this->file, $TOffset
        );

        $transtemp = $this->unpack(
            2 * $total
        );

        for($count = 0; $count < $total; ++$count) {
            if ($origtemp[$count * 2 + 1] != 0) {
                fseek($this->file, $origtemp[$count * 2 + 2]);
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
