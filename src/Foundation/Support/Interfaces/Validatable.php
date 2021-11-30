<?php namespace App\Foundation\Support\Interfaces;

interface Validatable
{
    /**
     * Validate this object (either entity or value object).
     *
     * @return \App\Foundation\Support\Validation
     */
    public function validate();

}