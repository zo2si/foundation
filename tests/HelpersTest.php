<?php

use App\Foundation\FoundationServiceProvider;

class HelpersTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $provider = new FoundationServiceProvider($this->app);
        $provider->register();
    }

    public function testUniqueCollect()
    {
        $collection = unique_collect([]);
        $this->assertInstanceOf(
            'App\Foundation\Support\UniqueCollection',
            $collection
        );
    }

    public function testQuantityRestrictedUniqueCollect()
    {
        $collection = qr_unique_collect([], 2, 1);
        $this->assertInstanceOf(
            'App\Foundation\Support\QuantityRestrictedUniqueCollection',
            $collection
        );
    }
}