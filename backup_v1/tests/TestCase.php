<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Set up the test environment.
     * Guarantees tests and RefreshDatabase ONLY run in isolated SQLite in-memory DB.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Hard safety guard: Never allow testing against MySQL or production database
        if (config('database.default') !== 'sqlite') {
            config(['database.default' => 'sqlite']);
            config(['database.connections.sqlite.database' => ':memory:']);
        }
    }
}
