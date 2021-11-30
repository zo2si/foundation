<?php

use App\Foundation\Support\QuantityRestrictedUniqueCollection;
use App\Foundation\Support\UniqueCollection;

if (!function_exists('unique_collect')) {
    /**
     * Create a unique collection.
     *
     * @param mixed $objects
     * @return \App\Foundation\Support\UniqueCollection
     */
    function unique_collect($objects = null)
    {
        return new UniqueCollection($objects);
    }
}

if (!function_exists('qr_unique_collect')) {
    /**
     * Create a quantity restricted unique collection.
     *
     * @param mixed $objects
     * @param int $min
     * @param int|null $max
     * @return \App\Foundation\Support\QuantityRestrictedUniqueCollection
     */
    function qr_unique_collect($objects = null, $min = 0, $max = null)
    {
        return new QuantityRestrictedUniqueCollection($objects, $min, $max);
    }
}