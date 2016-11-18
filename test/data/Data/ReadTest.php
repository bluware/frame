<?php

use Frame\Test\Data\Read;

class ReadTest extends PHPUnit_Framework_TestCase
{
    public function testContructor()
    {
        $data = new Read();

        return $data;
    }

    public function testGet()
    {
        $data = new Read(['name' => 'foo']);

        $this->assertEquals($data->name, 'foo');
        $this->assertEquals($data->get('name'), 'foo');
        $this->assertEquals($data->get('email', 0), 0);
    }

    public function testHas()
    {
        $data = new Read(['name' => 'foo']);

        $this->assertTrue($data->has('name'));
        $this->assertFalse(isset($data->email));
    }

    public function testIterator()
    {
        $data = new Read(['name' => 'foo', 'email' => 'bar']);

        foreach ($data as $key => $val) {
            if ($key === 'name')
                $this->assertTrue($val === 'foo');

            if ($key === 'email')
                $this->assertTrue($val === 'bar');
        }
    }

    public function testExport()
    {
        $data = new Read(['name' => 'foo', 'email' => 'bar']);

        $this->assertTrue(is_array($data->to('array')));
        $this->assertTrue(is_array($data->data()));
        $this->assertTrue(is_array($data()));
    }
}
