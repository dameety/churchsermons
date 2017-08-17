<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Service;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ServiceCreationTest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function creatingAServiceWorks()
    {
        $response = $this->call('POST', '/admin/service/api/new', [
            'name'        => $this->faker->text($maxNbChars = 15),
            'description' => $this->faker->sentence($nbWords = 30, $variableNbWords = true),
        ]);

        $response->assertStatus(200)->assertJson(['created' => true]);
    }

    /** @test */
    public function serviceNameIsRequired()
    {
        $response = $this->call('POST', '/admin/service/api/new', [
            'description' => $this->faker->sentence($nbWords = 30, $variableNbWords = true),
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function serviceNameMustBeUnique()
    {
        $service = factory(Service::class)->create();

        $response = $this->call('POST', '/admin/service/api/new', [
            'name'        => $service->name,
            'description' => $this->faker->sentence($nbWords = 30, $variableNbWords = true),
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function serviceDescriptionValidation()
    {
        $response = $this->call('POST', '/admin/service/api/new', [
            'name'        => $this->faker->text($maxNbChars = 15),
            'description' => $this->faker->sentence($nbWords = 500, $variableNbWords = true),
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['description']);
    }
}
