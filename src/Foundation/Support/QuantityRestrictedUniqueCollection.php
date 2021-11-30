<?php namespace App\Foundation\Support;

use App\Foundation\Support\Exceptions\MaximumReached;
use App\Foundation\Support\Exceptions\MinimumReached;

class QuantityRestrictedUniqueCollection extends UniqueCollection
{
    /**
     * Minimum items number of the collection, default 1.
     *
     * @var int
     */
    protected $minimum;

    /**
     * Maximum items number of the collection, default null,infinite.
     *
     * @var int|null
     */
    protected $maximum;

    /**
     * Create a quantity restricted unique collection.
     *
     * @param array $items
     * @param int $minimum
     * @param int|null $maximum
     */
    public function __construct($items = [], $minimum = 0, $maximum = null)
    {
        parent::__construct($items);
        $this->minimum = $minimum;
        $this->maximum = $maximum;
    }

    /**
     * Set the minimum items number of the collection.
     * You can set it dynamically for certain reasons.
     *
     * @param int $minimum
     * @return $this
     */
    public function setMinimum($minimum)
    {
        $this->minimum = $minimum;

        return $this;
    }

    /**
     * Set the minimum items number of the collection.
     * Set infinite number via parsing null.
     * You can set it dynamically for certain reasons.
     *
     * @param int|null $maximum
     * @return $this
     */
    public function setMaximum($maximum)
    {
        $this->maximum = $maximum;

        return $this;
    }

    /**
     * Unset the item at a given offset.
     * Throws an exception when minimum is reached.
     *
     * @param  string $key
     * @return void
     *
     * @throws \App\Foundation\Support\Exceptions\MinimumReached
     */
    public function offsetUnset($key)
    {
        if ($this->count() <= $this->minimum) {
            throw new MinimumReached($this->minimum);
        }
        parent::offsetUnset($key);
    }

    /**
     * Set the item at a given offset.
     * Throws an exception when maximum is reached.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @throws \App\Foundation\Support\Exceptions\MaximumReached
     */
    public function offsetSet($key, $value)
    {
        if ($this->maximum && $this->count() >= $this->maximum) {
            throw new MaximumReached($this->maximum);
        }
        parent::offsetSet($key, $value);
    }

    /**
     * Push an item onto the beginning of the collection.
     * Throws an exception when maximum is reached.
     *
     * @param mixed $value
     * @return $this
     *
     * @throws \App\Foundation\Support\Exceptions\MaximumReached
     */
    public function prepend($value)
    {
        if ($this->maximum && $this->count() >= $this->maximum) {
            throw new MaximumReached($this->maximum);
        }

        return parent::prepend($value);
    }

    /**
     * Validate if the collection matches the quantity restricts.
     *
     * @return \App\Foundation\Support\Validation
     */
    public function validate()
    {
        if ($this->count() < $this->minimum) {
            $this->getValidation()->fail('minimum', $this->minimum);
        }
        if ($this->maximum && $this->count() > $this->maximum) {
            $this->getValidation()->fail('maximum', $this->maximum);
        }

        return parent::validate();
    }

}