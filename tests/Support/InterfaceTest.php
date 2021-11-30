<?php

use App\Foundation\Support\Interfaces\Printable;
use App\Foundation\Support\Interfaces\Sanitizable;
use App\Foundation\Support\Interfaces\Validatable;
use App\Foundation\Support\Validation;

class InterfaceTest extends TestCase
{
    public function testValidatable()
    {
        $dummy = new Dummy(true);
        $this->assertInstanceOf('App\Foundation\Support\Validation',
            $dummy->validate());
    }

    public function testSanitizable()
    {
        $dummy = new Dummy(false);
        $dummy->sanitize();
        $this->assertTrue($dummy->stub);
    }

    public function testPrintable()
    {
        $this->expectOutputString('True');
        $dummy = new Dummy(true);
        echo $dummy;
    }
}

class Dummy implements Validatable, Sanitizable, Printable
{
    public $stub;

    public function __construct($stub)
    {
        $this->stub = $stub;
    }

    public function validate()
    {
        return new Validation();
    }

    public function sanitize()
    {
        $this->stub = true;
    }

    public function __toString()
    {
        return $this->stub ? "True" : "False";
    }
}