<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100)->index();
            $table->string('slug', 100)->index();
            $table->string('emoji', 5);
            $table->timestamps();
        });

        $now = \Carbon\Carbon::now()->toDateTimeString();

        \App\Models\Management\Sport::insert([
            [
                'name' => 'Airsoft',
                'slug' => 'airsoft',
                'emoji' => '🔫',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Baseball',
                'slug' => 'baseball',
                'emoji' => '⚾',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Basketball',
                'slug' => 'basketball',
                'emoji' => '🏀',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Cricket',
                'slug' => 'cricket',
                'emoji' => '🏏',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Field hockey',
                'slug' => 'field-hockey',
                'emoji' => '🏑',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Football',
                'slug' => 'football',
                'emoji' => '⚽',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Golf',
                'slug' => 'golf',
                'emoji' => '⛳',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Ice hockey',
                'slug' => 'ice-hockey',
                'emoji' => '🏒',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Rugby league',
                'slug' => 'rugby-league',
                'emoji' => '🏉',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Rugby union',
                'slug' => 'rugby-union',
                'emoji' => '🏉',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Soccer',
                'slug' => 'soccer',
                'emoji' => '⚽',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tennis',
                'slug' => 'tennis',
                'emoji' => '🎾',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Volleyball',
                'slug' => 'volleyball',
                'emoji' => '🏐',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Run',
                'slug' => 'run',
                'emoji' => '🏃',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sport');
    }
}
