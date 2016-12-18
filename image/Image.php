<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

/**
 * @subpackage Image
 */
class Image
{
    /**
     *  @var resource
     */
    protected $resource;

    /**
     *  @var integer
     */
    protected $x;

    /**
     *  @var integer
     */
    protected $y;

    /**
     *  @param resource
     */
    public function __construct($resource)
    {
        if (gettype($resource) !== 'resource')
            throw new \Exception("Bad resource type.");

        /**
         *  @var resource
         */
        $this->resource = $resource;

        /**
         *  @var integer
         */
        $this->x = imagesx($resource);

        /**
         *  @var integer
         */
        $this->y = imagesy($resource);
    }

    /**
     *  @param  integer $w [description]
     *  @param  integer $h [description]
     *  @return void
     */
    public function resize($w, $h)
    {
        /**
         *  @var resource
         */
        $resource = imagecreatetruecolor(
            $w, $h
        );

        /**
         *  @var void
         */
        imagecopyresized(
            $resource,
            $this->resource,
            0,
            0,
            0,
            0,
            $w,
            $h,
            $this->x,
            $this->y
        );

        /**
         *  @var bool
         */
        imagedestroy(
            $this->resource
        );

        /**
         *  @var resource
         */
        $this->resource = $resource;

        /**
         *  @var $this
         */
        return $this;
    }

    /**
     *  @param string $orientation
     *
     *  @return void
     */
    public function flip($orientation = 'horizontal')
    {
        switch ($orientation) {
            case 'horizontal':
            case 'h':
                imageflip($this->resource, IMG_FLIP_VERTICAL);
                break;

            case 'vertical':
            case 'v':
                imageflip($this->resource, IMG_FLIP_VERTICAL);
                break;

            case 'both':
            case 'b':
                imageflip($this->resource, IMG_FLIP_BOTH);
                break;

            default:
                throw new \Exception("Bad orientation");
                break;
        }

        /**
         *  @var $this
         */
        return $this;
    }

    public function rotate($degrees = 90)
    {
        $resource = imagerotate($this->resource, $degrees, 0);

        /**
         *  @var bool
         */
        imagedestroy(
            $this->resource
        );

        /**
         *  @var resource
         */
        $this->resource = $resource;

        /**
         *  @var $this
         */
        return $this;
    }

    public function crop($w, $h)
    {
        $x = $w; $y = $h;

        if ($w > $this->x && $h <= $this->y) {
            $x = $this->x;
            $y = floor(
                ($this->x / $w) * $h
            );
        }

        if ($w <= $this->x && $h > $this->y) {
            $y = $this->y;
            $x = floor(
                ($this->y / $h) * $w
            );
        }

        if (($w >= $this->x && $h >= $this->y) || ($w < $this->x && $h < $this->y)) {
            if ($w > $h) {
                $x = $this->x;
                $y = floor(
                    ($this->x / $w) * $h
                );
            }

            if ($w === $h) {
                $x = $y = (
                    $this->x > $this->y
                ) ? $this->y : $this->x;
            }

            if ($w < $h) {
                $x = floor(
                    ($this->y / $h) * $w
                );
                $y = $this->y;
            }
        }

        /**
         *  @var resource
         */
        $resource = imagecrop($this->resource, [
            'x'         => floor(($this->x - $x) / 2),
            'y'         => floor(($this->y - $y) / 2),
            'width'     => $x,
            'height'    => $y
        ]);

        /**
         *  @var bool
         */
        imagedestroy(
            $this->resource
        );

        /**
         *  @var resource
         */
        $this->resource = $resource;

        /**
         *  @var integer
         */
        $this->x = $x;

        /**
         *  @var integer
         */
        $this->y = $y;

        /**
         *  @var $this
         */
        return $this;
    }

    /**
     *  @param  string $input
     *  @param  mixed $data
     *
     *  @return static
     */
    public static function make($type, $data = null)
    {
        /**
         *  @var string
         */
        switch ($type) {
            case 'file': case 'filesystem': case 'url': case 'web': case 'http':
                /**
                 *  @var static
                 */
                return new static(
                    imagecreatefromstring(
                        file_get_contents($data)
                    )
                );
                break;

            case 'string': case 'str':
                /**
                 *  @var static
                 */
                return new static(
                    imagecreatefromstring($data)
                );
                break;

            case 'jpeg': case 'jpg': case 'image/jpeg':
                /**
                 *  @var static
                 */
                return new static(
                    imagecreatefromjpeg($data)
                );
                break;

            case 'png': case 'image/png':
                /**
                 *  @var static
                 */
                return new static(
                    imagecreatefrompng($data)
                );
                break;

            case 'gif': case 'image/gif':
                /**
                 *  @var static
                 */
                return new static(
                    imagecreatefromgif($data)
                );
                break;

            default:
                /**
                 *  @var static
                 */
                return new static(
                    imagecreatefromstring(
                        file_get_contents($type)
                    )
                );
                break;
        }

        throw new \Exception(
            "Bad type creation."
        );
    }

    /**
     *  @param  string  $file
     *  @param  integer $q
     *
     *  @return void
     */
    public function put($file, $q = 75)
    {
        return $this->jpeg($file, $q);
    }

    /**
     *  @param  string  $file
     *  @param  integer $q
     *
     *  @return void
     */
    public function jpeg($file, $q = 75)
    {
        imagejpeg(
            $this->resource, $file, $q
        );
    }

    /**
     *  @param  string  $file
     *  @param  integer $q
     *  @param  integer $filter
     *
     *  @return void
     */
    public function png($file, $q = 0, $filter = 0)
    {
        imagepng(
            $this->resource, $file, $q, $filter
        );
    }

    /**
     *  @param  string  $file
     *
     *  @return void
     */
    public function gif($file)
    {
        imagegif(
            $this->resource, $file
        );
    }

    /**
     *  @param  string $input
     *  @return mixed
     */
    public function __get($input)
    {
        return $this->{$input};
    }
}
