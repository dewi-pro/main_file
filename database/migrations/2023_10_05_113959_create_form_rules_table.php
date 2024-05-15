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
        Schema::create('form_rules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('form_id');
            $table->string('rule_name',191);
            $table->text('if_json');
            $table->text('then_json');
            $table->string('condition',191)->nullable();
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
        Schema::dropIfExists('form_rules');
    }
};
