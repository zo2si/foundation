<?php namespace App\Foundation\Domain;

use App\Foundation\Domain\Exceptions\EntityIdentityChanged;
use App\Foundation\Domain\Traits\EventPending;
use Carbon\Carbon;

abstract class Entity
{
    use EventPending;

    /**
     * The property name which presents identity of the entity.
     *
     * @var string
     */
    protected $identity_key = 'id';

    /**
     * Whether the entity is stored in repository.
     *
     * @var bool
     */
    protected $is_stored;

    /**
     *The Entity created time
     *
     * @var Carbon
     */
    public $created_at;

    /**
     *The Entity last updated time
     *
     * @var Carbon
     */
    public $updated_at;

    /**
     * Get the identity of the entity.
     *
     * @return int|string|\App\Foundation\Domain\ValueObject
     */
    public function getIdentity()
    {
        return $this->{$this->identity_key};
    }

    /**
     * Set the identity of the entity, can only be done once.
     *
     * @param int|string|\App\Foundation\Domain\ValueObject $id
     * @return $this
     *
     * @throws \App\Foundation\Domain\Exceptions\EntityIdentityChanged
     */
    public function setIdentity($id)
    {
        if (isset($this->{$this->identity_key})
            && $id != $this->{$this->identity_key}
        ) {
            throw new EntityIdentityChanged;
        }
        $this->{$this->identity_key} = $id;

        return $this;
    }

    /**
     * Whether the entity is stored in repository.
     *
     * @return bool
     */
    public function isStored()
    {
        return isset($this->is_stored) && $this->is_stored;
    }

    /**
     * Confirm the entity has been stored in repository.
     *
     * @return $this
     */
    public function stored()
    {
        $this->is_stored = true;

        return $this;
    }

    public function toArray($is_filter_null = false)
    {
        $arr = array();
        foreach ($this as $key => $value) {
            if ($is_filter_null) {
                if (isset($value)) {
                    $arr[$key] = $value;
                }
            } else {
                $arr[$key] = $value;
            }
        }
        return $arr;
    }

}



