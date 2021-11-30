<?php namespace App\Foundation\Support;

use App\Foundation\Support\Exceptions\DuplicatedValue;
use App\Foundation\Support\Interfaces\Validatable;
use App\Foundation\Support\Traits\Validating;
use Illuminate\Support\Collection;

class UniqueCollection extends Collection implements Validatable
{
    use Validating;

    /**
     * Remove an item from the collection by value.
     * Reset the index keys after removing by default.
     *
     * @param $value
     * @param bool $keep Whether keep the index keys.
     * @return $this
     */
    public function remove($value, $keep = false)
    {
        $duplicate = array_search($value, $this->items);
        if ($duplicate !== false) {
            $this->offsetUnset($duplicate);
            $keep || $this->items = array_values($this->items);
        }

        return $this;
    }

    /**
     * Set the item at a given offset.
     * Throws an exception when duplicated item added.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @throws \App\Foundation\Support\Exceptions\DuplicatedValue
     */
    public function offsetSet($key, $value)
    {
        $duplicate = array_search($value, $this->items);
        if ($duplicate && $duplicate != $key) {
            throw new DuplicatedValue;
        }

        parent::offsetSet($key, $value);
    }

    /**
     * Push an item onto the beginning of the collection.
     * Throws an exception when duplicated item added.
     *
     * @param mixed $value
     * @return $this
     *
     * @throws \App\Foundation\Support\Exceptions\DuplicatedValue
     */
    public function prepend($value)
    {
        $duplicate = array_search($value, $this->items);
        if ($duplicate !== false) {
            throw new DuplicatedValue;
        }

        return parent::prepend($value);
    }

    /**
     * Validate if the collection unique.
     *
     * @return \App\Foundation\Support\Validation
     */
    public function validate()
    {
        if ($this->unique()->count() == $this->count()) {
            return $this->getValidation();
        } else {
            return $this->getValidation()->fail('unique_collection', '重复');
        }
    }

}