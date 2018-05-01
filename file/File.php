<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

use Frame\File\Exception;
use Frame\File\Util;

class File extends \Frame\File\Data
{
    /**
     *  @var string
     */
    const PATTERN64 = '#^data:([\w\.\/\+\-]+);base64,([a-zA-Z0-9\/\r\n+]*={0,2})#i';

    /**
     *  @var array
     */
    protected $types = [];

    /**
     *  @var array
     */
    protected $limit = 0;

    /**
     *  @var bool
     */
    protected $valid = true;

    /**
     *  @param  string $data
     *
     *  @return void
     */
    public function __construct($data, $hash = 'md5')
    {
        parent::__construct($data);

        if (count($this->types) > 0) {
            $type = in_array($this->get('type'), $this->types, true);

            if ($type === false) {
                return $this->valid = false;
            }
        }

        switch ($hash) {
            case 'md5': default:
                $this->set(
                    'hash', @is_file(
                        $this->get('file')
                    ) ? md5_file(
                        $this->get('file')
                    ) : md5(
                        $this->get('file')
                    )
                );
                break;

            case 'crc32':
                $this->set(
                    'hash', crc32(
                        $this->get('file')
                    )
                );
                break;

            case 'sha1':
                $this->set(
                    'hash', @is_file(
                        $this->get('file')
                    ) ? sha1_file(
                        $this->get('file')
                    ) : sha1(
                        $this->get('file')
                    )
                );
                break;
        }

        /**
         *  @var array
         */
        $info = pathinfo(
            $this->get('name')
        );

        /*
         *  @var string
         */
        $this->set('name', $info[
            'filename'
        ]);

        /*
         *  @var boolean
         */
        if (array_key_exists('extension', $info) === true) {
            $extension = strtok($info['extension'], '?');
            $extension = strtok($extension, '&');

            /*
             *  @var string
             */
            $this->set('extension', $extension);
        }
    }

    /**
     * [from description].
     *
     * @param [type] $type [description]
     *
     * @return [type] [description]
     */
    public static function read($type, $data, $hash = 'md5')
    {
        switch ($type) {
            case 'array':
                return new static(
                    $data, $hash
                );
                break;

            case 'base64':
                if (gettype($data) !== 'array') {
                    throw new Exception(
                        'base64 file should be array [base64, name]'
                    );
                }

                list($base, $name) = $data;

                /**
                 *  @var bool
                 */
                $correct = boolval(
                    preg_match(static::PATTERN64, $base, $matches)
                );

                /*
                 *  @var boolean
                 */
                if ($correct === false) {
                    return;
                }

                /*
                 *  @var void
                 */
                array_shift($matches);

                /*
                 *  @var void
                 */
                list(
                    $type, $encoded
                ) = $matches;

                /**
                 *  @var float
                 */
                $size = (int) (
                    strlen(
                        rtrim($encoded, '=')
                    ) * 3 / 4
                );

                /**
                 *  @var string
                 */
                $file = base64_decode(
                    $encoded
                );

                return new static([
                    'file' => $file,
                    'type' => $type,
                    'size' => $size,
                    'name' => $name,
                ], $hash);
                break;

            case 'local':
                return new static([
                    'file' => $data,
                    'type' => mime_content_type($data),
                    'size' => filesize($data),
                    'name' => basename($data),
                ], $hash);
                break;

            case 'remote':
                $meta = Util::remote(
                    $data
                )->data([
                    'file' => file_get_contents(
                        $data
                    ),
                    'name' => basename($data),
                ]);

                return new static(
                    $meta->data(), $hash
                );
                break;
        }
    }

    public static function base64($data, $name, $hash = 'md5')
    {
        return static::read('base64', [
            $data, $name,
        ], $hash);
    }

    public static function local($path, $hash = 'md5')
    {
        return static::read(
            'local', $path, $hash
        );
    }

    public static function remote($uri, $hash = 'md5')
    {
        return static::read(
            'remote', $uri, $hash
        );
    }

    public static function content($event, $path, $data = null)
    {
        switch ($event) {
            case 'get':
                return file_get_contents(
                    $path
                );
                break;

            case 'put':
                return file_put_contents(
                    $path, $data
                );
                break;
        }
    }

    /**
     *  @param  string $key
     *
     *  @return mixed
     */
    public function is($input)
    {
        switch ($input) {
            case 'valid':
                return $this->valid;
                break;
        }

        return false;
    }
}
