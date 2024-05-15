<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seat_wise_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->longText('seat_booking_json');
            $table->text('services');
            $table->string('week_time',191)->nullable();
            $table->boolean('session_time_status')->default(0);
            $table->longText('session_time_json')->nullable();
            $table->boolean('limit_time_status')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('rolling_days_status')->default(0);
            $table->bigInteger('rolling_days')->nullable();
            $table->boolean('maximum_limit_status')->default(0);
            $table->bigInteger('maximum_limit')->nullable();
            $table->boolean('multiple_booking')->default(0);
            $table->boolean('email_notification')->default(0);
            $table->string('time_zone',191);
            $table->string('date_format',191);
            $table->string('time_format',191);
            $table->boolean('enable_note')->default(0);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('seat_wise_settings');
    }
};
