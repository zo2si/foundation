<?php

use App\Foundation\Support\Validation;

class ValidationTest extends TestCase
{
    public function testMessageBag()
    {
        $validation = new Validation();
        $this->assertInstanceOf('\Illuminate\Support\MessageBag',
            $validation->getMessageBag());
    }

    public function testFail()
    {
        $validation = new Validation();
        $validation->fail('key', 'message')->fail('key', 'message2');
        $this->assertEquals(2, $validation->getMessageBag()->count());
    }

    public function testIsValid()
    {
        $validation = new Validation();
        $this->assertTrue($validation->isValid());
        $validation->fail('key', 'message');
        $this->assertFalse($validation->isValid());
    }

    public function testOnFailed()
    {
        $validation = new Validation();
        $validation->fail('key', 'message');
        $validation->onFailed(function ($messages) {
            $this->assertInstanceOf('\Illuminate\Support\MessageBag',
                $messages);
            $this->assertEquals(1, $messages->count());
        });
    }

}
