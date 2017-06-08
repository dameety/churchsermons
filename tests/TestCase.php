<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    protected $sermon;
    protected $faker;

    public function setUp()
    {
        parent::setUp();
        $this -> sermon = new Sermon;
        $this -> faker = Faker::create();
    }
}
