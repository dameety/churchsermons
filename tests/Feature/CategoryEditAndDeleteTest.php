<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryEditAndDeleteTest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function categoryDeleteWorks()
    {
        $name = $this->faker->sentence($nbWords = 1, $variableNbWords = true);
        $request = [
            'name' => $name,
            'description' => $this->faker->text($maxNbChars = 200),
            'slug' => str_slug($name)
        ];

        //create it
        $response = $this->call('POST', '/admin/category/api/new', $request);
        $response->assertStatus(200)->assertJson(['created' => true]);

        //delete it
        $then = $this->call('DELETE', '/admin/category/api/delete/'. $request['slug']);
        $then->assertStatus(200)->assertjson(['deleted' => true]);
    }

    /** @test */
    public function categoryUpdateWorks()
    {
        $name = $this->faker->sentence($nbWords = 1, $variableNbWords = true);
        $request = [
            'name' => $name,
            'description' => $this->faker->text($maxNbChars = 200),
            'slug' => str_slug($name)
        ];

        //create it
        $response = $this->call('POST', '/admin/category/api/new', $request);
        $response->assertStatus(200)->assertJson(['created' => true]);

        //update it
        $then = $this->call('PATCH', '/admin/category/api/update/'. $request['slug'], [
            'name' => $this->faker->sentence($nbWords = 1, $variableNbWords = true),
            'description' => $this->faker->text($maxNbChars = 200)
        ]);

        $then->assertStatus(200)->assertjson(['updated' => true]);
    }
}
