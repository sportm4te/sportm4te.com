<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sport', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->index();
            $table->integer('sport_id')->index();
            $table->smallInteger('priority')->index();
            $table->timestamps();
        });

        Schema::table('user_sport', function (Blueprint $table) {
            $table->foreign('sport_id')->references('id')->on('sport');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sport');
    }
}
