<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CategoryCreationTest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function creatingACategoryWorks()
    {
        $response = $this->call('POST', '/admin/category/api/new', [
            'name'        => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'description' => $this->faker->text($maxNbChars = 200),
        ]);

        $response->assertStatus(200)->assertJson(['created' => true]);
    }

    /** @test */
    public function categoryNameIsRequired()
    {
        $response = $this->call('POST', '/admin/category/api/new', [
            'description' => $this->faker->text($maxNbChars = 200),
        ]);

        $response->assertStatus(302)->assertSessionHasErrors(['name']);
    }

    public function categoryNameMustBeUnique()
    {
        $category = factory(Category::class)->create();
        // words($nb = 3, $asText = false)

        $response = $this->json('POST', '/admin/category/api/new', [
            'name' => $category->name,
            'description' => $this->faker->text($maxNbChars = 200),
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function validationForNumberOfNameCharsWorks()
    {
        $response = $this->call('POST', '/admin/category/api/new', [
            'name'        => $this->faker->sentence($nbWords = 70, $variableNbWords = true),
            'description' => $this->faker->text($maxNbChars = 200),
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function validationForNumberOfDescriptionCharsWorks()
    {
        $response = $this->call('POST', '/admin/category/api/new', [
            'name'        => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'description' => $this->faker->text($minNbChars = 500),
        ]);

        $response->assertSessionHasErrors(['description']);
    }
}
