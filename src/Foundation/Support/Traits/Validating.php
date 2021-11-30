<?php namespace App\Foundation\Support\Traits;

use App\Foundation\Support\Validation;

trait Validating
{
    /**
     * Validation object to be used.
     *
     * @var \App\Foundation\Support\Validation
     */
    protected $validation;

    /**
     * Get the validation object.
     *
     * @return \App\Foundation\Support\Validation
     */
    protected function getValidation()
    {
        if (!isset($this->validation)) {
            $this->validation = new Validation();
        }

        return $this->validation;
    }

}