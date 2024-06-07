<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    //use CreatesApplication;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Run the migrations
        Artisan::call('migrate:reset');
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * Tear down the test environment.
     */
    protected function tearDown(): void
    {
        Artisan::call('migrate:reset');

        parent::tearDown();
    }
}
