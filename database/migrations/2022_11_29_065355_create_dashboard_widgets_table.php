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
        Schema::create('dashboard_widgets', function (Blueprint $table) {
            $table->id();
            $table->string('title',191)->nullable();
            $table->float('size')->nullable();
            $table->string('type',191)->nullable();
            $table->unsignedBigInteger('form_id')->nullable();
            $table->string('field_name',191)->nullable();
            $table->unsignedBigInteger('poll_id')->nullable();
            $table->string('chart_type',191)->nullable();
            $table->integer('position')->default(0);
            $table->integer('created_by')->default(0);
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
        Schema::dropIfExists('dashboard_widgets');
    }
};
