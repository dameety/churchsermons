<?php

namespace Tests;

use App\Models\User;
use App\Models\Admin;
use App\Models\Sermon;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected $user;
    protected $admin;
    protected $faker;
    protected $sermon;
    protected $newUser;
    protected $newSermon;

    public function setUp()
    {
        parent::setUp();
        $this->newUser = new User;
        $this-> newSermon = new Sermon;
        $this ->faker = Faker::create();
        $this->user = factory(User::class)->create();
        $this->admin = factory(Admin::class)->create();
        $this -> sermon = factory(Sermon::class)->create();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
