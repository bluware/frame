<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame
 *
 *  @package  Frame
 *  @author   Eugen Melnychenko
 */
namespace Frame\View;

use Frame\ViewInterface;
use Frame\Data\Readable;

/**
 * @subpackage View
 */
class Page implements PageInterface
{
    /**
     *  @var \Frame\IView
     */
    protected $view         = null;

    /**
     *  @var bool
     */
    protected $prevent      = null;

    /**
     *  @var array
     */
    protected $fill         = [];

    /**
     *  @var \Frame\IView
     */
    protected $content      = null;

    /**
     *  @var string
     */
    protected $render       = null;

    /**
     *  @var string
     */
    protected $layout       = null;

    /**
     *  @var array
     */
    protected $prop         = [];

    /**
     *  @var array
     */
    protected $call         = [];

    public function __construct(
        ViewInterface $view,
        $page,
        array $data = [],
        $prevent = false
    ) {
        /**
         *  @var \Frame\IView
         */
        $this->view     = $view;

        /**
         *  @var string
         */
        $this->page     = $page;

        /**
         *  @var boolean
         */
        $this->prevent  = $prevent;

        /**
         *  @var boolean
         */
        foreach ($data as $k => $v)
            $this->{
                is_object($v) && is_subclass_of(
                    $v, Readable::class
                ) ? 'prop' : (
                    is_callable(
                        $v
                    ) ? 'call' : 'prop'
                )
            }[$k] = $v;
    }

    /**
     *  @param  string $page
     *
     *  @return $this
     */
    public function layout($page)
    {
        /**
         *  @var boolean
         */
        if ($this->prevent === false)
            /**
             *  @var string
             */
            $this->layout = $page;

        /**
         *  @var $this
         */
        return $this;
    }

    /**
     *  @param  string $page
     *
     *  @return $this
     */
    public function template($page)
    {
        /**
         *  @var $this
         */
        return $this->layout($page);
    }

    /**
     *  @param  mixed $key
     *  @param  mixed $def
     *
     *  @return mixed
     */
    public function placeholder($key, $def = '')
    {
        /**
         *  @var mixed
         */
        return array_key_exists($key, $this->fill) === true ?
            $this->fill[$key] : $def;
    }

    /**
     *  @param  mixed $key
     *  @param  mixed $def
     *
     *  @return mixed
     */
    public function holder($key, $def = '')
    {
        /**
         *  @var mixed
         */
        return $this->placeholder($key, $def);
    }

    /**
     *  @param  mixed $key
     *  @param  mixed $def
     *
     *  @return mixed
     */
    public function hold($key, $def = '')
    {
        /**
         *  @var mixed
         */
        return $this->placeholder($key, $def);
    }

    /**
     *  @param  mixed $key
     *  @param  mixed $val
     *
     *  @return $this
     */
    public function filler($key, $val = null)
    {
        /**
         *  @var boolean
         */
        if (gettype($key) !== 'array')
            /**
             *  @var array
             */
            $key = [$key => $val];

        /**
         *  @var array
         */
        $this->fill = array_replace(
            $this->fill, $key
        );

        /**
         *  @var $this
         */
        return $this;
    }

    /**
     *  @param  mixed $key
     *  @param  mixed $val
     *
     *  @return $this
     */
    public function fill($key, $val = null)
    {
        /**
         *  @var $this
         */
        return $this->filler($key, $val);
    }

    /**
     *  @param  string $page
     *
     *  @return string
     */
    public function partial($page)
    {
        /**
         *  @var string
         */
        return $this->extract($page);
    }

    /**
     *  @param  string $page
     *
     *  @return string
     */
    public function part($page)
    {
        /**
         *  @var string
         */
        return $this->partial($page);
    }

    /**
     *  @return mixed
     */
    public function content()
    {
        /**
         *  @var mixed
         */
        return $this->layout !== null ?
            $this->content : null;
    }

    /**
     *  @return mixed
     */
    public function inner()
    {
        /**
         *  @var mixed
         */
        return $this->content();
    }

    /**
     *  @return string
     */
    public function render()
    {
        /**
         *  @var boolean
         */
        if ($this->render !== null)
            /**
             *  @var string
             */
            return $this->render;

        /**
         *  @var string
         */
        $this->content = $this->extract(
            $this->page
        );

        /**
         *  @var boolean
         */
        if ($this->prevent === true)
            /**
             *  @var string
             */
            return $this->render = $this->content;

        /**
         *  @var boolean
         */
        if ($this->layout !== null) {
            /**
             *  @var boolean
             */
            $this->prevent  = true;

            /**
             *  @var string
             */
            $this->content  = $this->extract(
                $this->layout
            );

            /**
             *  @var string
             */
            return $this->render = $this->content;
        }

        /**
         *  @var string
         */
        return $this->render = $this->content;
    }

    /**
     *  @param  string $path
     *
     *  @return string
     */
    protected function extract($path)
    {
        /**
         *  @var void
         */
        ob_start();

        /**
        *  @var string
        */
        include $this->view->find(
            $path
        );

        /**
         *  @var string
         */
        return ob_get_clean();
    }

    /**
     *  @param scalar $method
     *  @param array  $arguments
     *
     *  @return mixed
     */
    public function __call($method, $arguments)
    {
        /**
         *  @var mixed
         */
        return call_user_func_array(
            $this->call[$method], $arguments
        );
    }

    /**
     *  @param scalar $method
     *  @param array  $arguments
     *
     *  @return mixed
     */
    public function __get($key)
    {
        /**
         *  @var mixed
         */
        return $this->prop[$key];
    }

    /**
     *  @var boolean
     */
    public function __isset($key)
    {
        /**
         *  @var boolean
         */
        return array_key_exists($key, $this->prop);
    }

    /**
     *  @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
