<?php

use App\Foundation\Support\UniqueCollection;

class UniqueCollectionTest extends TestCase
{

    public function testRemove()
    {
        $collection = $this->getDummyCollection();
        $collection->remove($this->getDummyObject('B', 2));

        $expected = [
            ['A', 1],
            ['C', 3],
        ];
        $expected = new UniqueCollection($this->provideObjects($expected));
        $this->assertEquals($expected, $collection);

        $collection->remove(($this->getDummyObject('B', 2)));
        $this->assertEquals($expected, $collection);
    }

    public function testKeepIndexAfterRemove()
    {
        $collection = $this->getDummyCollection();
        $collection->remove($this->getDummyObject('B', 2), true);

        $expected = [
            0 => ['A', 1],
            2 => ['C', 3],
        ];
        $expected = new UniqueCollection($this->provideObjects($expected));
        $this->assertEquals($expected, $collection);

        $collection->remove($this->getDummyObject('B', 2), true);
        $this->assertEquals($expected, $collection);
    }

    public function testPush()
    {
        $collection = $this->getDummyCollection();
        $collection->push($this->getDummyObject('D', 4));

        $expected = [
            ['A', 1],
            ['B', 2],
            ['C', 3],
            ['D', 4],
        ];
        $expected = new UniqueCollection($this->provideObjects($expected));
        $this->assertEquals($expected, $collection);

        $this->setExpectedException(
            'App\Foundation\Support\Exceptions\DuplicatedValue'
        );
        $collection->push($this->getDummyObject('D', 4));
    }

    public function testPrepend()
    {
        $collection = $this->getDummyCollection();
        $collection->prepend($this->getDummyObject('D', 4));

        $expected = [
            ['D', 4],
            ['A', 1],
            ['B', 2],
            ['C', 3],
        ];
        $expected = new UniqueCollection($this->provideObjects($expected));
        $this->assertEquals($expected, $collection);

        $this->setExpectedException(
            'App\Foundation\Support\Exceptions\DuplicatedValue'
        );
        $collection->prepend($this->getDummyObject('D', 4));
    }

    public function testPut()
    {
        $collection = $this->getDummyCollection();
        $collection->put(3, $this->getDummyObject('D', 4));

        $expected = [
            ['A', 1],
            ['B', 2],
            ['C', 3],
            ['D', 4],
        ];
        $expected = new UniqueCollection($this->provideObjects($expected));
        $this->assertEquals($expected, $collection);

        $collection->put(3, $this->getDummyObject('D', 4));
        $this->assertEquals($expected, $collection);
    }

    public function testValidatable()
    {
        $data = [
            ['A', 1],
            ['B', 2],
            ['C', 3],
        ];
        $collection = new UniqueCollection($this->provideObjects($data));
        $this->assertTrue($collection->validate()->isValid());
        $data = [
            ['A', 1],
            ['B', 2],
            ['B', 2],
        ];
        $collection = new UniqueCollection($this->provideObjects($data));
        $this->assertFalse($collection->validate()->isValid());
    }

    protected function getDummyCollection()
    {
        $data = [
            ['A', 1],
            ['B', 2],
            ['C', 3],
        ];

        return new UniqueCollection($this->provideObjects($data));
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