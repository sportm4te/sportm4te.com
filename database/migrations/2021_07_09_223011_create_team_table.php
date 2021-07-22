<?php

use App\Models\Management\Timezone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('event_id')->index();
            $table->string('name')->index();
            $table->timestamps();
        });

        Schema::create('team_member', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('team_id')->index();
            $table->integer('user_id')->index();
            $table->timestamps();
        });

        Schema::table('team', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('event');
        });

        Schema::table('team_member', function (Blueprint $table) {
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
        Schema::dropIfExists('team');
        Schema::dropIfExists('team_member');
    }
}
