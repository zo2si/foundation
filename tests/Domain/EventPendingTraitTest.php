<?php

use App\Foundation\Domain\Event;

class EventPendingTraitTest extends TestCase
{

    public function testEventPublishing()
    {
        $this->expectsEvents('App\Foundation\Domain\Event');
        $stub = $this->getMockForTrait(
            'App\Foundation\Domain\Traits\EventPending'
        );

        // empty
        $events = PHPUnit_Framework_Assert::readAttribute($stub, 'events');
        $this->assertEquals([], $events);

        // add events
        $stub->pendEvent(new Event());
        $events = PHPUnit_Framework_Assert::readAttribute($stub, 'events');
        $this->assertEquals(1, count($events));
        $stub->pendEvent(new Event());
        $events = PHPUnit_Framework_Assert::readAttribute($stub, 'events');
        $this->assertEquals(2, count($events));

        // publish events
        $stub->publishEvents();
        $events = PHPUnit_Framework_Assert::readAttribute($stub, 'events');
        $this->assertEquals([], $events);
    }

}
