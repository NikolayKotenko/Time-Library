<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThingsShapeALifestylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('things_shape_a_lifestyles', function (Blueprint $table) {
            $table->id();
            $table->string('tag');
//            $table->string('articles');
//            $table->string('books');
//            $table->string('audio-books');
//            $table->string('podcasts');
//            $table->string('films');
//            $table->string('video-self-dev');
//            $table->string('anime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('things_shape_a_lifestyles');
    }
}
