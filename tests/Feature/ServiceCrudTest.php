<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ServiceCrudTest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function serviceDeleteWorks()
    {
        $name = $this->faker->text($maxNbChars = 15);

        $request = [
            'name' => $name,
            'description' => $this->faker->sentence($nbWords = 30, $variableNbWords = true),
            'slug' => str_slug($name)
        ];

        //create it
        $response = $this->call('POST', '/admin/service/api/new', $request);
        $response->assertStatus(200)->assertJson(['created' => true]);

        //delete it
        $then = $this->call('DELETE', '/admin/service/api/delete/'. $request['slug']);
        $then->assertStatus(200)->assertjson(['deleted' => true]);
    }

    /** @test */
    public function serviceUpdateWorks()
    {
        $name = $this->faker->text($maxNbChars = 15);

        $request = [
            'name' => $name,
            'description' => $this->faker->sentence($nbWords = 30, $variableNbWords = true),
            'slug' => str_slug($name)
        ];

        //create it
        $response = $this->call('POST', '/admin/service/api/new', $request);
        $response->assertStatus(200)->assertJson(['created' => true]);

        //update it
        $then = $this->call('PATCH', '/admin/service/api/update/'. $request['slug'], [
            'name' => $this->faker->text($maxNbChars = 15),
            'description' => $this->faker->sentence($nbWords = 10, $variableNbWords = true)
        ]);

        $then->assertStatus(200)->assertjson(['updated' => true]);
    }
}
