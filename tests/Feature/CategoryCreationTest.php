<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

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

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function categoryNameMustBeUnique()
    {
        $category = factory(Category::class)->create();

        $response = $this->call('POST', '/admin/category/api/new', [
            'name'        => $category->name,
            'description' => $this->faker->text($maxNbChars = 200),
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
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
