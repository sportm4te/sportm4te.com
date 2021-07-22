<?php

use App\Models\Management\Timezone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('author_id')->index();
            $table->integer('user_id')->index();
            $table->smallInteger('stars')->unsigned()->nullable()->index();
            $table->text('review')->nullable();
            $table->timestamps();
        });

        Schema::table('review', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review');
    }
}
