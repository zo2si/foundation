<?php

class ValueObjectTest extends TestCase
{
    public function testEquality()
    {
        $value1 = new DummyValueObject();
        $value1->a = '111';
        $value1->b = 2;
        $value2 = new DummyValueObject();
        $value2->a = '111';
        $value2->b = 2;
        $this->assertTrue($value2->isEqualTo($value1));
        $this->assertTrue($value1->isEqualTo($value1));
        $value2->b = 5;
        $this->assertFalse($value2->isEqualTo($value1));
        $this->assertFalse($value1->isEqualTo($value2));
    }

    public function testRecursiveEquality()
    {
        $value1 = new DummyValueObject();
        $inner1 = new DummyValueObject();
        $inner1->a = '111';
        $inner1->b = 2;
        $value1->a = $inner1;
        $value1->b = 2;
        $value2 = new DummyValueObject();
        $inner2 = new DummyValueObject();
        $inner2->a = '111';
        $inner2->b = 2;
        $value2->a = $inner2;
        $value2->b = 2;
        $this->assertTrue($value2->isEqualTo($value1));
        $this->assertTrue($value1->isEqualTo($value1));
        $inner2->b = 5;
        $this->assertFalse($value2->isEqualTo($value1));
        $this->assertFalse($value1->isEqualTo($value2));
    }

    public function testEqualityOfDifferentObjects()
    {
        $value1 = new DummyValueObject();
        $value2 = new DummyComparisonValueObject();
        $this->assertFalse($value2->isEqualTo($value1));
        $this->assertFalse($value1->isEqualTo($value2));
    }
}

class DummyValueObject extends App\Foundation\Domain\ValueObject
{
    public $a;
    public $b;
}

class DummyComparisonValueObject extends App\Foundation\Domain\ValueObject
{
    public $a;
    public $b;
}