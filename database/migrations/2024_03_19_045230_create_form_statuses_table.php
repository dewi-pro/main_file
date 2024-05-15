<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color');
            $table->integer('status')->comment('1 -> active / 0 -> deactive')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_statuses');
    }
};
