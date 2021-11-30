<?php

use App\Foundation\Domain\Event;
use App\Foundation\Domain\Interfaces\Repository as RepositoryInterface;
use App\Foundation\Domain\Repository;

class RepositoryTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function register($interface, $implements)
    {
        app()->singleton($interface, $implements);
    }

    public function testEntityStoredAfterSave()
    {
        $this->register('dummy', 'DummyRepository');
        $entity = new DummyEntity();
        $entity->setIdentity(1);
        app('dummy')->save($entity);
        $this->assertTrue($entity->isStored());
    }

    public function testPublishEventsAfterSave()
    {
        $this->expectsEvents('App\Foundation\Domain\Event');
        $this->register('dummy', 'DummyRepository');
        $entity = new DummyEntity();
        $entity->setIdentity(1)->pendEvent(new Event());
        app('dummy')->save($entity);
    }

    public function testEntityStoredAfterFetch()
    {
        $this->register('dummy', 'DummyRepository');
        $entity = new DummyEntity();
        $entity->setIdentity(1);
        app('dummy')->save($entity);
        /** @var \App\Foundation\Domain\Entity $entity */
        $entity = app('dummy')->fetch(1);
        $this->assertTrue($entity->isStored());
    }

    public function testFetchNullEntityWithException()
    {
        $this->setExpectedException(
            'App\Foundation\Domain\Exceptions\EntityNotFound',
            "Can't find identity 2 in DummyRepository"
        );
        $this->register('dummy', 'DummyRepository');
        app('dummy')->fetch(2, [], true);
    }

    public function testFetchNullEntityWithoutException()
    {
        $this->register('dummy', 'DummyRepository');
        $entity = app('dummy')->fetch(2);
        $this->assertNull($entity);
    }

    public function testAdditionalMethods()
    {
        $this->register('dummy', 'DummyRepository');
        /** @var DummyRepository $dummy */
        $dummy = app('dummy');
        $all = $dummy->fetchAll();
        $this->assertTrue(is_array($all));
    }

}

class DummyRepository extends Repository implements RepositoryInterface
{
    protected static $storage = [];

    protected function store($entity)
    {
        self::$storage[$entity->getIdentity()] = $entity;
    }

    protected function reconstitute($id, $params = [])
    {
        if (isset(self::$storage[$id])) {
            return self::$storage[$id];
        }

        return null;
    }

    public function fetchAll()
    {
        return self::$storage;
    }
}
