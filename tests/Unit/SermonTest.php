<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Sermon;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManagerStatic as Image;

class SermonTest extends TestCase
{
    /** @test */
    public function uploadsFolderExists()
    {
        $folder = 'uploads/';
        $this->assertFileExists(public_path($folder));
    }

    /** @test */
    public function returnFalseIfWrongImageAdded()
    {
        $path = public_path('img/sermon-image-for-test.jpg');
        $result = $this->sermon->addMediaToSermon($path);
        $this->assertFalse($result);
    }

    /** @test */
    public function addImageToSermon()
    {
        $path = UploadedFile::fake()->image('sermonImage.jpg', 300, 150)->size(20);
        $result = $this->newSermon->addMediaToSermon($path);
        $this->assertTrue($result);
    }

    /** @test */
    public function addImageUrlToSavedSermon()
    {
        Image::make(public_path('testimage.jpg'))->resize(300, 200)->save(public_path('testimage.png'), 60);

        $sermon = $this->newSermon;
        $sermon->addMediaToSermon(public_path('testimage.png'));
        $sermon->title = $this->faker->sentence($nbWords = 3, $variableNbWords = true);
        $sermon->service_id = factory(Service::class)->create()->id;
        $sermon->category_id = factory(Category::class)->create()->id;
        $sermon->save();

        $result = Sermon::addImageUrlToSermon($sermon->slug);
        $this->assertTrue($result);
    }
}
