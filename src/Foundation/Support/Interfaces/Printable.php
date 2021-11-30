<?php namespace App\Foundation\Support\Interfaces;

interface Printable
{
    /**
     * Print or echo this object.
     *
     * @return string
     */
    public function __toString();
}