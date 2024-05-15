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
        Schema::create('booking_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->longText('json');
            $table->float('amount')->nullable();
            $table->string('currency_symbol',191)->nullable();
            $table->string('currency_name',191)->nullable();
            $table->string('transaction_id',191)->nullable();
            $table->string('payment_type',191)->nullable();
            $table->date('booking_slots_date')->nullable();
            $table->text('booking_slots')->nullable();
            $table->date('booking_seats_date')->nullable();
            $table->string('booking_seats_session',191)->nullable();
            $table->text('booking_seats')->nullable();
            $table->string('status',191)->default('pending');
            $table->boolean('booking_status')->default(1);
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
        Schema::dropIfExists('booking_values');
    }
};
