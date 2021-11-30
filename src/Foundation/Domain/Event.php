<?php namespace App\Foundation\Domain;

use Carbon\Carbon;

class Event
{
    /**
     * The payload of the event.
     *
     * @var mixed
     */
    public $payload;

    /**
     * Time when event was first published.
     *
     * @var null|\Carbon\Carbon
     */
    protected $published_at;

    /**
     * Create a new event.
     *
     * @param mixed $payload
     */
    public function __construct($payload = null)
    {
        $this->payload = $payload;
    }

    /**
     * Publish the event.
     */
    public function publish()
    {
        if (!isset($this->published_at)) {
            $this->published_at = new Carbon();
            event($this);
        }
    }
}