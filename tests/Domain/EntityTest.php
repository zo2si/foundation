<?php
use App\Foundation\Domain\Entity;

class EntityTest extends TestCase
{
    public function testIdentity()
    {
        $entity = new DummyEntity();
        $entity->setIdentity('unique');
        $this->assertEquals('unique', $entity->getIdentity());
    }

    public function testIdentityChange()
    {
        $this->setExpectedException(
            'App\Foundation\Domain\Exceptions\EntityIdentityChanged'
        );
        $entity = new DummyEntity();
        $entity->setIdentity('unique');
        $entity->setIdentity('only');
    }

    public function testStore()
    {
        $entity = new DummyEntity();
        $this->assertFalse($entity->isStored());
        $entity->stored();
        $this->assertTrue($entity->isStored());
    }
}

class DummyEntity extends Entity
{
}
