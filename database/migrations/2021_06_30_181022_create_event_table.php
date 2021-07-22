<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->index();
            $table->integer('parent_id')->nullable()->index();
            $table->integer('category_id')->index();
            $table->smallInteger('privacy')->unsigned()->index();
            $table->integer('place_id')->index();
            $table->string('name', 100)->index();
            $table->string('location', 150)->index();
            $table->smallInteger('level')->unsigned()->index();
            $table->string('description', 1000)->nullable();
            $table->datetime('start')->index();
            $table->datetime('end')->index();
            $table->date('deadline')->nullable();
            $table->integer('registration_limit')->nullable();
            $table->integer('timezone_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('event', function (Blueprint $table) {
            $table->unique(['parent_id', 'start', 'end']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('parent_id')->references('id')->on('event');
            $table->foreign('category_id')->references('id')->on('sport');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event');
    }
}
