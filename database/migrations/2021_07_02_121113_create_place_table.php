<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('place_id', 400)->unique();
            $table->integer('timezone_id')->nullable();
            $table->string('formatted_address')->index();
            $table->string('street_number')->nullable();
            $table->string('subpremise')->nullable();
            $table->string('premise')->nullable();
            $table->string('route')->nullable();
            $table->string('sublocality_level_1')->nullable();
            $table->string('sublocality_level_2')->nullable();
            $table->string('locality')->nullable();
            $table->string('administrative_area_level_1')->nullable();
            $table->string('administrative_area_level_2')->nullable();
            $table->string('administrative_area_level_3')->nullable();
            $table->string('administrative_area_level_4')->nullable();
            $table->string('administrative_area_level_5')->nullable();
            $table->string('country');
            $table->integer('utc_offset')->nullable();
            $table->string('postal_code')->nullable();
            $table->point('gps')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('place_id')->references('id')->on('place');
        });

        Schema::table('event', function (Blueprint $table) {
            $table->foreign('place_id')->references('id')->on('place');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place');
    }
}
