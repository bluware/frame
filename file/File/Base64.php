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
class Base64
{
    /**
     *  @var string
     */
    protected $pattern = '#^data:(.*?);base64,([a-zA-Z0-9\/\r\n+]*={0,2})#i';

    /**
     *  @var array
     */
    protected $types    = [];

    /**
     *  @var string
     */
    protected $type;

    /**
     *  @var string
     */
    protected $name;

    /**
     *  @var integer
     */
    protected $size         = 0;

    /**
     *  @var string
     */
    protected $data;

    /**
     *  @var boolean
     */
    protected $valid        = false;

    /**
     *  @var boolean
     */
    protected $hash         = null;

    /**
     *  @var boolean
     */
    protected $extension    = null;

    /**
     *  @param  string $data
     *
     *  @return void
     */
    public function __construct($data, $name = null, $hash = 'md5')
    {
        /**
         *  @var boolean
         */
        $correct = boolval(
            preg_match($this->pattern, $data, $matches)
        );

        /**
         *  @var boolean
         */
        if ($correct === false)
            return;

        /**
         *  @var void
         */
        array_shift($matches);

        /**
         *  @var void
         */
        list(
            $this->type, $encoded
        ) = $matches;

        /**
         *  @var bool
         */
        if (gettype($this->type) === 'array' && sizeof($this->types) > 0)
            /**
             *  @var bool
             */
            if (in_array($this->type, $this->types, true) === false)
                /**
                 *  @var void
                 */
                return;

        /**
         *  @var float
         */
        $this->size = (int) (
            strlen(
                rtrim($encoded, '=')
            ) * 3 / 4
        );

        /**
         *  @var string
         */
        $this->data = base64_decode(
            $encoded
        );

        /**
         *  @var boolean
         */
        $this->valid    = true;

        /**
         *  @var string
         */
        switch ($hash) {
            case 'sha1':
                /**
                 *  @var string
                 */
                $this->hash      = sha1($this->data);
                break;

            case 'crc32':
                /**
                 *  @var string
                 */
                $this->hash      = crc32($this->data);
                break;

            case 'md5': default:
                /**
                 *  @var string
                 */
                $this->hash      = md5($this->data);
                break;
        }


        if ($name === null)
            return;

        /**
         *  @var array
         */
        $info = pathinfo($name);

        /**
         *  @var string
         */
        $this->name = $info[
            'filename'
        ];

        /**
         *  @var boolean
         */
        if (array_key_exists('extension', $info) === true)
            /**
             *  @var string
             */
            $this->extension = $info['extension'];
    }

    /**
     *  @param  string $file
     *
     *  @return void
     */
    public function put($file)
    {
        file_put_contents(
            $file,
            $this->data
        );
    }

    /**
     *  @param  string $key
     *
     *  @return mixed
     */
    public function __get($key)
    {
        return $this->{$key};
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
