<?php

use App\Models\Sermon;
use App\Models\Service;
use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class SermonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $categories = Category::all()->pluck('id')->toArray();
        $services = Service::all()->pluck('id')->toArray();

        foreach (range(1, 50) as $index) {
            $sermon = Sermon::create([
                'preacher'      => $faker->name,
                'service_id'    => $faker->randomElement($services),
                'category_id'   => $faker->randomElement($categories),
                 'datepreached' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'title'         => $faker->sentence($nbWords = 3, $variableNbWords = true),
            ]);
        }
    }
}
