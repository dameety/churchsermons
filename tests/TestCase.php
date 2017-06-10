<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;


    protected $sermon;
    protected $faker;

    public function setUp()
    {
        parent::setUp();
        $this -> sermon = new Sermon;
        $this -> faker = Faker::create();
    }
}
