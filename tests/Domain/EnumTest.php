<?php

use App\Foundation\Domain\Enum;

class EnumTest extends TestCase
{
    public function testCreate()
    {
        $dummy = new EnumDummy(EnumDummy::A);
        $this->assertEquals(EnumDummy::A, $dummy->alphabet);
        $dummy = new EnumDummy(2);
        $this->assertEquals(EnumDummy::B, $dummy->alphabet);
    }

    public function testCreateFailed()
    {
        $this->setExpectedException(
            'App\Foundation\Domain\Exceptions\EnumNotExists'
        );
        new EnumDummy(4);
    }

    public function testGetEnum()
    {
        $dummy = new EnumDummy(EnumDummy::A);
        $this->assertEquals(EnumDummy::A, $dummy->getEnum());
    }

    public function testPrintable()
    {
        $this->expectOutputString('This is A.');
        echo new EnumDummy(EnumDummy::A);
    }

    public function testAcceptableEnums()
    {
        $this->assertEquals([
            EnumDummy::A => 'This is A.',
            EnumDummy::B => 'This is B.',
            EnumDummy::C => 'This is C.',
        ], EnumDummy::acceptableEnums());
    }

    public function testValidatable()
    {
        $dummy = new EnumDummy(EnumDummy::A, false);
        $this->assertTrue($dummy->validate()->isValid());
        $dummy = new EnumDummy(4, false);
        $this->assertFalse($dummy->validate()->isValid());
        $this->assertTrue(is_string($dummy->validate()->getMessageBag()->first('alphabet')));
    }

}

class EnumDummy extends Enum
{
    const A = 1;
    const B = 2;
    const C = 3;

    public $alphabet;

    protected $enum = 'alphabet';

    protected static $enums = [
        self::A => 'This is A.',
        self::B => 'This is B.',
        self::C => 'This is C.',
    ];

}