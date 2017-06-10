<?php

namespace Tests\Unit;

use App\Sermon;
use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SermonTest extends TestCase
{

    public function testUploadsFolderExists() {

        $folder  = 'uploads/';
        $this->assertFileExists(public_path($folder));

    }

    public function testAddMediaToSermon () {

        $path = public_path('img/sermon-image-for-test.jpg');
        $result = $this->sermon->addMediaToSermon($path);
        $this->assertEquals(true, $result);

    }

    public function testAddImageUrlToSermon () {

        $path = public_path('img/sermon-image-for-test.jpg');
        $sermon = $this->sermon;
        $sermon->title = $this->faker->sentence($nbWords = 3, $variableNbWords = true);
        $sermon->service_id = 2;
        $sermon->category_id = 3;
        $sermon -> addMediaToSermon($path);
        $sermon -> save();
        $result = Sermon::addImageUrlToSermon($sermon->slug);
        $this->assertEquals(true, $result);

    }

    public function testThatSermonImageCanBeUpdated () {

        $path = public_path('img/sermon-image-for-test.jpg');
        $sermon = $this->sermon;
        $sermon->title = $this->faker->sentence($nbWords = 3, $variableNbWords = true);
        $sermon->service_id = 2;
        $sermon->category_id = 3;
        $sermon -> addMediaToSermon($path);
        $sermon -> save();
        Sermon::addImageUrlToSermon($sermon->slug);

        $result = Sermon::addImageUrlToUpdatedSermon($sermon->slug);
        $this->assertEquals(true, $result);

    }


}
