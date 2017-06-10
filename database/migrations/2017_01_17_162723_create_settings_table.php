<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('churchName')->nullable();
            $table->string('churchLogoPath')->nullable();
            $table->string('contactEmail')->nullable();
            $table->text('vision')->nullable();
            $table->string('appLogoName')->nullable();
            $table->string('appLogoPath')->nullable();
            $table->string('appLogoExtension')->nullable();
            $table->text('welcomeEmailBody')->nullable();
            $table->string('welcomeEmailHeading')->nullable();
            $table->string('maxFileSize')->nullable();

            // for stripe small letter k
            $table->string('api_key')->nullable();
            $table->string('plan_id')->nullable();
            $table->string('plan_name')->nullable();
            $table->integer('plan_amount')->nullable();
            $table->string('plan_interval')->nullable();
            $table->string('plan_currency')->nullable();
            $table->string('plan_description')->nullable();
            

            $table->string('slug');
            
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
        Schema::dropIfExists('settings');
    }
}
