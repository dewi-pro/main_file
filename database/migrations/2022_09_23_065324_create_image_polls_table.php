<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_polls', function (Blueprint $table) {
            $table->id();
            $table->string('vote',191)->nullable();
            $table->string('name',191)->nullable();
            $table->bigInteger('poll_id');
            $table->string('location',191);
            $table->string('session_id',191)->nullable();
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
        Schema::dropIfExists('image_polls');
    }
}
