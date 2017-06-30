<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserLoginTest extends TestCase
{
    use WithoutMiddleware;

    public function loginWorks()
    {
        $user = factory(User::class)->create();

        $response = $this->call('POST', '/login', [
            'email'    => $user->email,
            'password' => $user->password,
        ]);

        $response->assertRedirect('/home');
    }

    /** @test */
    public function userMustHaveAccountToLogin()
    {
        $response = $this->call('POST', '/login', [
            'email'    => $this->faker->unique()->safeEmail,
            'password' => $this->faker->text($maxNbChars = 20),
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function emailMustBeValid()
    {
        $response = $this->call('POST', '/login', [
            'email'    => $this->faker->name,
            'password' => $this->faker->text($maxNbChars = 20),
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
