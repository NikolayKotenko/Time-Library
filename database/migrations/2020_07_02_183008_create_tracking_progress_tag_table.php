<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingProgressTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_progress_tags', function (Blueprint $table) {
            $table->id();
            $table->integer('time_library_id');
            $table->integer('minutes');
            $table->integer('hours');
            $table->integer('number_of_seasons');
            $table->integer('series');
            $table->integer('number_of_pages');
            $table->integer('percent');
            $table->integer('total_time_audio_books');
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
        Schema::dropIfExists('tracking_progress_tags');
    }
}
