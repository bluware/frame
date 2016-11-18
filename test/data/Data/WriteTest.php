<?php

use Frame\Test\Data\Write;

class WriteTest extends PHPUnit_Framework_TestCase
{
    public function testSet()
    {
        $data = new Write(['name' => 'foo']);

        $this->assertInstanceOf('Frame\Test\Data\Write', $data->set('email', 'bar'));

        $this->assertEquals($data->email, 'bar');
    }

    public function testImport()
    {
        $data = new Write(['name' => 'foo']);

        $this->assertInstanceOf('Frame\Test\Data\Write', $data->data(['email' => 'bar']));
        $this->assertEquals($data->email, 'bar');

        $this->assertInstanceOf('Frame\Test\Data\Write', $data(['phone' => 911]));
        $this->assertEquals($data->phone, 911);
    }
}
