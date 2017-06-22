<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryCreationTest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function creatingACategoryWorks()
    {
        $response = $this->actingAs($this->admin)->call('POST', '/admin/category/api/new', [
            'name' => $this->faker->sentence($nbWords = 3, $variableNbWords = true),
            'description' => $this->faker->text($maxNbChars = 200),
        ]);
        // dd($response->getContent());

        $response->assertStatus(200)
            ->assertJson(['created' => true]);
    }

    /** @test */
    public function categoryNameIsRequired()
    {
        $response = $this->call('POST', '/admin/category/api/new', [

            'description' => $this->faker->text($maxNbChars = 200),
        ]);

        $response->assertSessionHasErrors(["name"]);
    }

    /** @test */
    // public function categoryNameMustBeUnique()
    // {
    //     $name = $this->faker->sentence($nbWords = 3, $variableNbWords = true);
    //     $response = $this->call('POST', '/admin/category/api/new', [
    //         'name' => $name,
    //         'description' => $this->faker->text($maxNbChars = 200),
    //     ]);

    //     dd($response->getContent());
    //     $response->assertSessionHasErrors(["name"]);
    // }
}
