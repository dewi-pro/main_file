<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AmountToFormValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_values', function (Blueprint $table) {
            $table->float('amount')->after('json')->nullable();
            $table->string('currency_symbol',191)->after('amount')->nullable();
            $table->string('currency_name',191)->after('currency_symbol')->nullable();
            $table->string('transaction_id',191)->after('currency_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_values', function (Blueprint $table) {
            //
        });
    }
}
