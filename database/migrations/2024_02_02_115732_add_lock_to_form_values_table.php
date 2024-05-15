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
        Schema::table('form_values', function (Blueprint $table) {
            $table->tinyInteger('form_edit_lock_status')->comment('1-On ,0-off')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_values', function (Blueprint $table) {
            //
        });
    }
};
