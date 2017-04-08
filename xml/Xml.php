<?php

/**
 *  Bluware PHP Lite & Scaleable Web Frame.
 *
 *  @author   Eugen Melnychenko
 */

namespace Frame;

class Xml
{
    protected $properties;

    protected $cdata;

    protected $content;

    public function __construct(
        array $data,
        $properties = [],
        $version = '1.0',
        $encoding = 'UTF-8'
    ) {
        $this->properties = $properties;

        $content = [
            sprintf('<?xml version="%s" encoding="%s"?>', $version, $encoding),
            $this->gather($data),
        ];

        $this->content = implode(
            "\n", $content
        );
    }

    private function properties($key)
    {
        $result = '';
        if (
            !empty($this->properties[$key])
        ) {
            $values = [$key];
            foreach ($this->properties[$key] as $name => $value) {
                $values[] = sprintf('%s="%s"', $name, $value);
            }
            $result = implode(' ', $values);
        } else {
            return $key;
        }

        return $result;
    }

    protected function whitespace($times = 0, $size = 4)
    {
        return $times > 0 ? str_repeat(' ', $times * $size) : '';
    }

    protected function gather($data, $whitespace = 0, $parent = null)
    {
        $result = [];
        foreach ($data as $key => $value) {
            if (
                is_array($value)
            ) {
                if (
                    is_numeric($key)
                ) {
                    $result[] = $this->gather($value, $whitespace, $parent);
                } else {
                    $result[] = sprintf(
                        '%s<%s>',
                        $this->whitespace($whitespace),
                        $this->properties($key)
                    );

                    $result[] = $this->gather(
                        $value, $whitespace + 1, $key
                    );

                    $result[] = sprintf(
                        '%s</%s>',
                        $this->whitespace($whitespace),
                        $key
                    );
                }
            } else {
                if (
                    is_numeric($key)
                ) {
                    $result[] = sprintf(
                        '%s<%s />',
                        $this->whitespace($whitespace),
                        $this->properties($value)
                    );
                } else {
                    $result[] = sprintf(
                        '%s<%s>%s</%s>',
                        $this->whitespace($whitespace),
                        $this->properties($key),
                        $value,
                        $key
                    );
                }
            }
        }

        return implode("\n", $result);
    }

    public function __get($input)
    {
        return $this->{$input};
    }
}
