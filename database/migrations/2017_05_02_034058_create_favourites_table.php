<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favourites', function (Blueprint $table) {
            $table->increments('id');
        
            $table->integer('user_id')->unsigned();
            $table->integer('sermon_id')->unsigned();
            $table->string('title')->nullable();
            $table->string('preacher')->nullable();
            $table->string('datepreached')->nullable();
            $table->string('status')->nullable();
            $table->string('path')->nullable();
            $table->string('filename')->nullable();
            $table->string('slug')->unique()->nullable();

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
        Schema::dropIfExists('favourites');
    }
}
