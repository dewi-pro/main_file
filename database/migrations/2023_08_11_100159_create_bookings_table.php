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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('business_name',191);
            $table->string('business_email',191);
            $table->string('business_website',191);
            $table->text('business_address');
            $table->string('business_number',191);
            $table->string('business_phone',191);
            $table->string('business_logo',191);
            $table->string('booking_slots',191);
            $table->longText('json')->nullable();
            $table->boolean('payment_status')->default(0);
            $table->decimal('amount',10,2)->nullable();
            $table->string('currency_symbol',191)->nullable();
            $table->string('currency_name',191)->nullable();
            $table->string('payment_type',191)->nullable();
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('bookings');
    }
};
