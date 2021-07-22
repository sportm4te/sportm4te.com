<?php

use App\Models\Management\Timezone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->index();
            $table->integer('friend_id')->nullable()->index();
            $table->boolean('confirmed')->nullable()->index();
            $table->timestamps();
            $table->unique([
                'user_id',
                'friend_id',
            ]);
        });

        Schema::table('friend', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('friend_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friend');
    }
}
