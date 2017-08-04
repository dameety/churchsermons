<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AdminCreationTest extends TestCase
{
    use WithoutMiddleware;

    public function adminCanBeCreated()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($admin)->call('POST', 'admin/admin/api/new', [
            'name'       => $this->faker->name,
            'email'      => $this->faker->unique()->safeEmail,
            'password'   => $this->faker->text($maxNbChars = 20),
            'permission' => 'Standard Admin',
        ]);
        
        $response->assertStatus(200)->assertJson(['created' => true]);
    }

    /** @test */
    public function adminMustBeSuperToCreateNewAdmin()
    {
        $admin = factory(Admin::class)->create(['permission' => 'Standard Admin']);

        $response = $this->actingAs($admin)->call('POST', 'admin/admin/api/new', [
            'name'       => $this->faker->name,
            'email'      => $this->faker->unique()->safeEmail,
            'password'   => $this->faker->text($maxNbChars = 20),
            'permission' => 'Standard Admin',
        ]);
        $response->assertStatus(200)->assertJson(['created' => false]);
    }

    /** @test */
    public function nameInputIsRequired()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($admin)->call('POST', 'admin/admin/api/new', [
            'email'      => $this->faker->unique()->safeEmail,
            'password'   => $this->faker->text($maxNbChars = 20),
            'permission' => 'Standard Admin',
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function passwordInputIsRequired()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($admin)->call('POST', 'admin/admin/api/new', [
            'name'       => $this->faker->name,
            'email'      => $this->faker->unique()->safeEmail,
            'permission' => 'Standard Admin',
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function emailInputIsRequired()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($admin)->call('POST', 'admin/admin/api/new', [
            'name'       => $this->faker->name,
            'password'   => $this->faker->text($maxNbChars = 20),
            'permission' => 'Standard Admin',
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function emailMustBeValidCheck()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($admin)->call('POST', 'admin/admin/api/new', [
            'name'       => $this->faker->name,
            'email'      => $this->faker->name,
            'password'   => $this->faker->text($maxNbChars = 20),
            'permission' => 'Standard Admin'
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['email']);
    }

    public function emailMustBeUniqueValidCheck()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($admin)->json('POST', 'admin/admin/api/new', [
            'name' => $this->faker->name,
            'email' => $admin->email,
            'password' => $this->faker->text($maxNbChars = 20),
            'permission' => 'Standard Admin'
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['email']);
    }

    public function adminDeleteWorks()
    {
        $admin = factory(Admin::class)->create();
        $admin2 = factory(Admin::class)->create();

        $response = $this->actingAs($admin)->call('DELETE', 'admin/admin/api/delete/'.$admin2->slug);

        $response->assertStatus(200)->assertJson(['deleted' => true]);
    }

    /** @test */
    public function standardAdminCannotAuthorizeDelete()
    {
        $admin = factory(Admin::class)->create();
        $admin2 = factory(Admin::class)->create(['permission' => 'Standard Admin']);

        $response = $this->actingAs($admin2)->call('DELETE', 'admin/admin/api/delete/'.$admin->slug);

        $response->assertStatus(200)->assertJson(['deleted' => false]);
    }
}
