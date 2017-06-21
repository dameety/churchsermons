<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserLoginTest extends TestCase
{
    /** @test */
    public function loginWorks()
    {
        $email = $this->faker->unique()->safeEmail;
        $password = $this->faker->text($maxNbChars = 20);

        $register = $this->json('POST', '/register', [
            'email' => $email,
            'password' => $password,
            'name' => $this->faker->name,
            'password_confirmation' => $password
        ]);

        $response = $this->json('POST', '/login', [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertRedirect('/home');
    }

    /** @test */
    public function userMustHaveAccountToLogin()
    {
        $response = $this->call('POST', '/login', [
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->text($maxNbChars = 20)
        ]);

        $response -> assertSessionHasErrors(["email"]);
    }

    /** @test */
    public function emailMustBeValid()
    {
        $response = $this->call('POST', '/login', [
            'email' => $this->faker->name,
            'password' => $this->faker->text($maxNbChars = 20)
        ]);

        $response -> assertSessionHasErrors(["email"]);
    }
}
