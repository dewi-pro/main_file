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
            $table->string('submited_forms_ip')->nullable()->after('form_status');
            $table->string('submited_forms_country')->nullable()->after('submited_forms_ip');
            $table->string('submited_forms_region')->nullable()->after('submited_forms_country');
            $table->string('submited_forms_city')->nullable()->after('submited_forms_region');
            $table->string('submited_forms_latitude')->nullable()->after('submited_forms_city');
            $table->string('submited_forms_longitude')->nullable()->after('submited_forms_latitude');
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
