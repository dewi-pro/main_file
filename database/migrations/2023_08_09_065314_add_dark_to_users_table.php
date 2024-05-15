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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('dark_layout')->default(0)->after('phone_verified_at');
            $table->boolean('rtl_layout')->default(0)->after('dark_layout');
            $table->boolean('transprent_layout')->default(1)->after('rtl_layout');
            $table->string('theme_color',191)->default('theme-2')->after('transprent_layout');
            $table->boolean('users_grid_view')->default(0)->after('theme_color');
            $table->boolean('forms_grid_view')->default(0)->after('users_grid_view');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
