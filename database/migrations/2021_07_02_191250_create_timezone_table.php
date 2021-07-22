<?php

use App\Models\Management\Timezone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimezoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timezone', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('timezone')->index();
            $table->timestamps();
        });

        Schema::table('event', function (Blueprint $table) {
            $table->foreign('timezone_id')->references('id')->on('timezone');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('timezone_id')->references('id')->on('timezone');
        });

        Schema::table('place', function (Blueprint $table) {
            $table->foreign('timezone_id')->references('id')->on('timezone');
        });

        $timezone = new \MBarlow\Timezones\Timezones;
        foreach (array_keys($timezone->timezoneList()) as $key) {
            $_timezone = new Timezone();
            $_timezone->timezone = $key;
            $_timezone->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timezone');
    }
}
