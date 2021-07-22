<?php

use App\Models\Management\Timezone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('event_id')->index();
            $table->integer('team_id')->nullable()->index();
            $table->integer('user_id')->nullable()->index();
            $table->float('score')->index();
            $table->timestamps();
        });

        Schema::table('score', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('event');
            $table->foreign('team_id')->references('id')->on('team');
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
        Schema::dropIfExists('score');
    }
}
