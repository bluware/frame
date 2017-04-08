<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

class I18n
{
    protected $dictionary = [];

    protected $locale = 'en';

    public function __construct($locale = 'en')
    {
        $this->locale = $locale;
    }

    public function translate($sentense, $locale = null)
    {
        if ($locale === null) {
            $locale = $this->locale;
        }

        $isset = array_key_exists(
            $locale, $this->dictionary
        );

        return $isset === true ? $this->dictionary[
            $locale
        ]->get(
            $sentense,
            $sentense
        ) : $sentense;
    }

    protected function unpack($bytes, $file, $ed = false)
    {
        return unpack(
            sprintf(
                '%s%d', $ed === false ? 'V' : 'N', $bytes
            ), fread(
                $file, 4 * $bytes
            )
        );
    }

    public function scan($dir)
    {
        if (substr($dir, -1) !== '/') {
            $dir .= '/';
        }

        $pattern = sprintf('%s*.mo', $dir);

        foreach (glob($pattern) as $file) {
            $locale = str_replace(
                [$dir, '.mo'], '', $file
            );

            $this->read($file, $locale);
        }
    }

    public function locale($locale = null)
    {
        if ($locale === null) {
            return $this->locale;
        }

        $this->locale = $locale;

        return $this;
    }

    public function read($path, $locale, array $options = [])
    {
        $data = [];

        $ed = false;

        $file = @fopen($path, 'rb');

        if ($file === false) {
            throw new \Exception('No file');
        }
        if (@filesize($path) < 10) {
            @fclose($file);

            throw new \Exception('\''.$path.'\' is not a gettext file');
        }

        $input = $this->unpack(1, $file, $ed);

        $ed = strtolower(
            substr(
                dechex($input[1]), -8
            )
        );

        if ($ed !== '950412de' && $ed !== 'de120495') {
            @fclose($file);

            throw new \Exception('\''.$path.'\' is not a gettext file');
        }

        $ed = $ed === 'de120495';

        $input = $this->unpack(
            1, $file, $ed
        );

        $input = $this->unpack(
            1, $file, $ed
        );

        $total = $input[1];

        $input = $this->unpack(
            1, $file, $ed
        );

        $OOffset = $input[1];

        $input = $this->unpack(
            1, $file, $ed
        );

        $TOffset = $input[1];

        fseek(
            $file, $OOffset
        );

        $origtemp = $this->unpack(
            2 * $total, $file, $ed
        );

        fseek(
            $file, $TOffset
        );

        $transtemp = $this->unpack(
            2 * $total, $file, $ed
        );

        for ($count = 0; $count < $total; ++$count) {
            if ($origtemp[$count * 2 + 1] != 0) {
                fseek(
                    $file, $origtemp[$count * 2 + 2]
                );

                $original = @fread($file, $origtemp[$count * 2 + 1]);
                $original = explode("\0", $original);
            } else {
                $original[0] = '';
            }

            if ($transtemp[$count * 2 + 1] != 0) {
                fseek(
                    $file,
                    $transtemp[$count * 2 + 2]
                );

                $translate = fread(
                    $file,
                    $transtemp[$count * 2 + 1]
                );

                $translate = explode(
                    "\0", $translate
                );

                if (count($original) > 1) {
                    $data[$locale][$original[0]] = $translate;

                    array_shift($original);

                    foreach ($original as $orig) {
                        $data[$locale][$orig] = '';
                    }
                } else {
                    $data[$locale][$original[0]] = $translate[0];
                }
            }
        }

        @fclose($file);

        $data[$locale][''] = trim(
            $data[$locale]['']
        );

        // $this->meta[$path] = isset(
        //     $data[$locale]['']
        // ) ? $data[$locale][''] : 'No meta';

        unset(
            $data[$locale]['']
        );

        $isset = array_key_exists($locale, $this->dictionary);

        if ($isset === false) {
            $this->dictionary[$locale] = new Data();
        }

        $this->dictionary[$locale]->replace(
            $data[$locale]
        );

        return $data[$locale];
    }
}
