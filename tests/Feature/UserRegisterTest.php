<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRegisterTest extends TestCase
{
    /** @test */
    public function userCanRegistser()
    {
        $password = $this->faker->text($maxNbChars = 20);
        $response = $this->json('POST', '/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertRedirect('/home');
    }

    /** @test */
    public function userNeedEmailToCreateAccount()
    {
        $password = $this->faker->text($maxNbChars = 20);
        $response = $this->call('POST', '/register', [
            'name' => $this->faker->name,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertSessionHasErrors(["email"]);
    }

    /** @test */
    public function userNeedValidEmail()
    {
        $password = $this->faker->text($maxNbChars = 20);
        $response = $this->call('POST', '/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->name,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertSessionHasErrors(["email"]);
    }

    /** @test */
    public function passwordConfirmationMustMatch()
    {
        $password = $this->faker->text($maxNbChars = 20);
        $response = $this->call('POST', '/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->text($maxNbChars = 10),
            'password_confirmation' => $this->faker->text($maxNbChars = 15)
        ]);
        $response->assertSessionHasErrors(["password"]);
    }

        /** @test */
    public function passwordShouldNotBeLessThan8Chars()
    {
        $password = $this->faker->text($maxNbChars = 20);
        $response = $this->call('POST', '/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->text($maxNbChars = 7),
            'password_confirmation' => $this->faker->text($maxNbChars = 15)
        ]);
        $response->assertSessionHasErrors(["password"]);
    }
}
