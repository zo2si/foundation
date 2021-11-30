<?php

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    public function createApplication()
    {
        $app = new Illuminate\Foundation\Application(
            realpath(__DIR__ . '/../')
        );

        return $app;
    }
}