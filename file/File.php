<?php

namespace Frame;

use Frame\File\Except;

class File
{
    /**
     *  @var array
     */
    public static $support = [
        'temp', 'binary'
    ];

    /**
     *  binary || temp
     *
     * @var enum
     */
    protected $scope    = 'temp';

    /**
     *  Natural file size
     *
     *  @var integer
     */
    protected $size     = 0;

    /**
     *  Mime of file
     *
     *  @var string
     */
    protected $type;

    /**
     *  Name of file
     *
     *  @var string
     */
    protected $name;

    /**
     *  In memory handler
     *
     *  @var binary
     */
    protected $binary;

    /**
     *  In memory handler
     *
     *  @var binary
     */
    protected $temp;

    /**
     *
     */
    public function __construct($scope = 'temp', array $data)
    {
        /**
         *  @var bool
         */
        if (in_array($scope, static::$support, true) === false)
            /**
             *  @var Err
             */
            throw new Except('Scope do not supports.');

        /**
         *  @var array
         */
        $require = [
            'name', 'size', 'type', $scope
        ];

        /**
         *  @var array
         */
        $filter = array_intersect(
            $require, array_keys(
                $data
            )
        );

        /**
         *  @var bool
         */
        if (sizeof($filter) !== sizeof($require))
            /**
             *  @var Err
             */
            throw new Except('Wrong input params.');


        /**
         *  @var iterable
         */
        foreach ($data as $input => $value)
            /**
             *  @var mixed
             */
            $this->{$input} = $value;
    }

    /**
     * [from description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public static function from($type, $data)
    {
        switch ($type) {
            case 'native':
                # code...
                break;

            case 'base64':
                # code...
                break;

            case 'memory':
                # code...
                break;

            case 'web': case 'url': case 'http':
                # code...
                break;

            case 'filesystem': case 'fs': case 'file':
                # code...
                break;
        }
    }

    public function put($path)
    {
        switch ($this->scope) {
            case 'memory':
                file_put_contents($path, $this->memory);
                break;

            case 'temp':
                move_uploaded_file($path, $this->temp);
                break;
        }
    }
}
