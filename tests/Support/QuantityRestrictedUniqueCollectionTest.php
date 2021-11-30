<?php

use App\Foundation\Support\QuantityRestrictedUniqueCollection;

class QuantityRestrictedUniqueCollectionTest extends TestCase
{
    public function testCreateAndSetter()
    {
        $collection = new QuantityRestrictedUniqueCollection();
        $expected = new QuantityRestrictedUniqueCollection();
        $expected->setMinimum(0)->setMaximum(null);
        $this->assertEquals($expected, $collection);

        $collection = new QuantityRestrictedUniqueCollection([], 1);
        $expected = new QuantityRestrictedUniqueCollection();
        $expected->setMinimum(1);
        $this->assertEquals($expected, $collection);

        $collection = new QuantityRestrictedUniqueCollection([], 2, 10);
        $expected = new QuantityRestrictedUniqueCollection();
        $expected->setMinimum(2)->setMaximum(10);
        $this->assertEquals($expected, $collection);
    }

    public function testMinimum()
    {
        $collection = $this->getDummyCollection()->setMinimum(2);
        $collection->remove($this->getDummyObject('A', 1));
        $this->assertEquals(2, $collection->count());

        $this->setExpectedException(
            'App\Foundation\Support\Exceptions\MinimumReached'
        );
        $collection->remove($this->getDummyObject('B', 2));
    }

    public function testMaximumPrepend()
    {
        $collection = $this->getDummyCollection()->setMaximum(4);
        $collection->prepend($this->getDummyCollection('D', 4));
        $this->assertEquals(4, $collection->count());

        $this->setExpectedException(
            'App\Foundation\Support\Exceptions\MaximumReached'
        );
        $collection->prepend($this->getDummyObject('E', 5));
    }

    public function testMaximumPush()
    {
        $collection = $this->getDummyCollection()->setMaximum(4);
        $collection->push($this->getDummyCollection('D', 4));
        $this->assertEquals(4, $collection->count());

        $this->setExpectedException(
            'App\Foundation\Support\Exceptions\MaximumReached'
        );
        $collection->push($this->getDummyObject('E', 5));
    }

    public function testMaximumPut()
    {
        $collection = $this->getDummyCollection()->setMaximum(4);
        $collection->put(4, $this->getDummyCollection('D', 4));
        $this->assertEquals(4, $collection->count());

        $this->setExpectedException(
            'App\Foundation\Support\Exceptions\MaximumReached'
        );
        $collection->put(5, $this->getDummyObject('E', 5));
    }

    public function testNullMaximum()
    {
        $collection = $this->getDummyCollection();
        $collection->setMaximum(3)->setMaximum(null);
        $collection->push($this->getDummyCollection('D', 4));
        $this->assertEquals(4, $collection->count());
    }

    public function testValidatable()
    {
        $collection = $this->getDummyCollection();
        $collection->setMinimum(3);
        $this->assertTrue($collection->validate()->isValid());
        $collection->setMinimum(4);
        $this->assertFalse($collection->validate()->isValid());

        $collection = $this->getDummyCollection();
        $collection->setMaximum(3);
        $this->assertTrue($collection->validate()->isValid());
        $collection->setMaximum(2);
        $this->assertFalse($collection->validate()->isValid());
    }

    protected function getDummyCollection()
    {
        $data = [
            ['A', 1],
            ['B', 2],
            ['C', 3],
        ];

        return new QuantityRestrictedUniqueCollection($this->provideObjects($data));
    }

    protected function provideObjects($data)
    {
        $objects = [];
        foreach ($data as $key => $value) {
            $objects[$key] = $this->getDummyObject($value[0], $value[1]);
        }

        return $objects;
    }

    protected function getDummyObject($a, $b)
    {
        $object = new DummyValueObject();
        $object->a = $a;
        $object->b = $b;

        return $object;
    }
}