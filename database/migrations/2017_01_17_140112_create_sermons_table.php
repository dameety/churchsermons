<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSermonsTable extends Migration
{
    /**
     * Run the migrations. 
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sermons', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('preacher')->nullable();
            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('datepreached')->nullable();
            $table->date('preachedon')->nullable();
            $table->string('status')->default('free');
            $table->string('size')->nullable();
            $table->string('path')->nullable();
            $table->string('type')->nullable();
            $table->string('filename')->nullable();
            $table->string('imageurl')->nullable();
            $table->integer('downloadCount')->nullable();
            $table->timestamp('lastDownloadTime')->nullable();
            $table->string('lastDownloadBy')->nullable();
            $table->string('slug')->unique();

            $table->softdeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sermons');
    }
}
