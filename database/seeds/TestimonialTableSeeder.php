<?php

use Illuminate\Database\Seeder;

class TestimonialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Testimonial::truncate();
        factory(App\Models\Testimonial::class, 3)->create();
    }
}
