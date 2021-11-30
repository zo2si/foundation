<?php namespace App\Foundation\Domain\Traits;

use App\Foundation\Domain\Event;

Trait EventPending
{
    /**
     * List of pending events.
     *
     * @var \App\Foundation\Domain\Event[]
     */
    protected $events = [];

    /**
     * Pend an event.
     *
     * @param \App\Foundation\Domain\Event $event
     */
    public function pendEvent(Event $event)
    {
        $this->events[] = $event;
    }

    /**
     * Publish all pending events.
     */
    public function publishEvents()
    {
        foreach ($this->events as $event) {
            $event->publish();
        }
        $this->events = [];
    }

}
