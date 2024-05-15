<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // if not exist, add the new column
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address',191)->nullable()->after('avatar');
            }
            if (!Schema::hasColumn('users', 'country')) {
                $table->string('country',191)->default('India')->after('address');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone',191)->nullable()->after('country');
            }

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
}
