<?php

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
        factory(App\Models\Sermon::class, 10)->create();
    }
}
