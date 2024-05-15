<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingPollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_polls', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->dateTime('vote')->nullable();
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
        Schema::dropIfExists('meeting_polls');
    }
}
