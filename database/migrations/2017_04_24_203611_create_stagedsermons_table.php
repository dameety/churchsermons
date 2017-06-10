<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStagedsermonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stagedsermons', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->nullable();
            $table->string('size')->nullable();
            $table->string('path')->nullable();
            $table->string('type')->nullable();
            $table->string('filename')->nullable();
            $table->string('slug')->unique();

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
        Schema::dropIfExists('stagedsermons');
    }
}
