<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_registration', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('event_id')->index();
            $table->integer('user_id')->index();
            $table->boolean('approved')->nullable()->index();
            $table->boolean('seen')->nullable()->index();
            $table->timestamps();
            $table->unique(['event_id', 'user_id']);
        });

        Schema::table('event_registration', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('event');
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
        Schema::dropIfExists('event_registration');
    }
}
