<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame;

use Frame\Image\Exception;

use Frame\File;

/**
 * @subpackage Image
 */
class Image extends File
{
    protected $types  = [
        'image/jpeg', 'image/png', 'image/gif'
    ];

    /**
     *  @param resource
     */
    public function __construct($data, $hash = 'md5')
    {
        parent::__construct($data, $hash);

        $infs = @is_file(
            $file = $this->get('file')
        );

        if ($infs === false || $infs === null) {
            $image = @imagecreatefromstring(
                $infs
            );
        } else {
            $mime = mime_content_type($file);

            switch ($mime) {
                case 'image/png':
                    $image = @imagecreatefrompng(
                        $file
                    );
                    break;

                default:
                    $image = @imagecreatefromstring(
                        file_get_contents($file)
                    );
                    break;
            }
        }

        $image = @imagecreatefromstring(
            $infs === false || $infs === null ?
                $file : file_get_contents($file)
        );

        if (gettype($image) !== 'resource')
            throw new Exception("Bad image to resource convertation.");

            imagealphablending($image, true);
            imagesavealpha($image, false);

        /**
         *  @var void
         */
        $this->data([
            'image' => $image,
            'x'     => imagesx($image),
            'y'     => imagesy($image)
        ]);
    }

    /**
     *  @param  integer $w
     *  @param  integer $h
     *  @return void
     */
    public function resize($w, $h)
    {
        /**
         *  @var resource
         */
        $image = imagecreatetruecolor(
            $w, $h
        );

        imagealphablending($image, false);
        imagesavealpha($image, true);

        // imagealphablending($this->get('image'), false);

        /**
         *  @var void
         */
        imagecopyresampled(
            $image,
            $this->get('image'),
            0,
            0,
            0,
            0,
            $w,
            $h,
            $this->get('x'),
            $this->get('y')
        );



        /**
         *  @var bool
         */
        imagedestroy(
            $this->get('image')
        );

        /**
         *  @var resource
         */
        $this->set('image', $image);

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
                imageflip($this->get('image'), IMG_FLIP_VERTICAL);
                break;

            case 'vertical':
            case 'v':
                imageflip($this->get('image'), IMG_FLIP_VERTICAL);
                break;

            case 'both':
            case 'b':
                imageflip($this->get('image'), IMG_FLIP_BOTH);
                break;

            default:
                throw new Exception("Bad orientation. Supports : 'horizontal', 'h', 'vertical', 'v', 'both', 'b'");
                break;
        }

        /**
         *  @var $this
         */
        return $this;
    }

    public function rotate($degrees = 90)
    {
        $image = imagerotate($this->get('image'), $degrees, 0);

        /**
         *  @var bool
         */
        imagedestroy(
            $this->get('image')
        );

        /**
         *  @var resource
         */
        $this->set('image', $image);

        /**
         *  @var $this
         */
        return $this;
    }

    public function crop($w, $h)
    {
        $x = $w; $y = $h;

        if ($w > $this->get('x') && $h <= $this->get('y')) {
            $x = $this->get('x');
            $y = floor(
                ($this->get('x') / $w) * $h
            );
        }

        if ($w <= $this->get('x') && $h > $this->get('y')) {
            $y = $this->get('y');
            $x = floor(
                ($this->get('y') / $h) * $w
            );
        }

        if (($w >= $this->get('x') && $h >= $this->get('y')) || ($w < $this->get('x') && $h < $this->get('y'))) {
            if ($w > $h) {
                $x = $this->get('x');
                $y = floor(
                    ($this->get('x') / $w) * $h
                );
            }

            if ($w === $h) {
                $x = $y = (
                    $this->get('x') > $this->get('y')
                ) ? $this->get('y') : $this->get('x');
            }

            if ($w < $h) {
                $x = floor(
                    ($this->get('y') / $h) * $w
                );
                $y = $this->get('y');
            }
        }

        /**
         *  @var resource
         */
        $image = imagecrop($this->get('image'), [
            'x'         => floor(($this->get('x') - $x) / 2),
            'y'         => floor(($this->get('y') - $y) / 2),
            'width'     => $x,
            'height'    => $y
        ]);

        imagealphablending($image, true);
        imagesavealpha($image, false);

        /**
         *  @var bool
         */
        imagedestroy(
            $this->get('image')
        );

        /**
         *  @var resource
         */
        $this->set('image', $image);

        /**
         *  @var integer
         */
        $this->set('x', $x);

        /**
         *  @var integer
         */
        $this->set('y', $y);

        /**
         *  @var $this
         */
        return $this;
    }

    /**
     *  @param  string  $image
     *  @param  integer $q
     *
     *  @return void
     */
    public function put($image, $q = 75)
    {
        return $this->jpeg($image, $q);
    }

    /**
     *  @param  string  $image
     *  @param  integer $q
     *
     *  @return void
     */
    public function jpeg($image, $q = 75)
    {
        imagejpeg(
            $this->get('image'), $image, $q
        );
    }

    /**
     *  @param  string  $image
     *  @param  integer $q
     *  @param  integer $filter
     *
     *  @return void
     */
    public function png($image, $q = 0, $filter = 0)
    {
        imagepng(
            $this->get('image'), $image, $q, $filter
        );
    }

    /**
     *  @param  string  $image
     *
     *  @return void
     */
    public function gif($image)
    {
        imagegif(
            $this->get('image'), $image
        );
    }

    public function __clone()
    {
        $cloning = imagecreatetruecolor(
            $this->get('x'), $this->get('x')
        );

        imagecopy(
            $cloning,
            $this->get('image'),
            0, 0, 0, 0,
            $this->get('x'),
            $this->get('x')
        );

        $this->set('image', $cloning);
    }
}
