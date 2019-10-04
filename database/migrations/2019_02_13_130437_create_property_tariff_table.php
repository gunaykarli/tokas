<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTariffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('property_tariff', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tariff_id');
            $table->integer('property_id');
            $table->string('amount_of_value')->nullable();//extra field for the pivot.
            $table->string('text_of_value')->nullable();//extra field for the pivot.
            $table->timestamps();
        });
        /**
        Schema::create('property_tariff', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tariff_id');
            $table->integer('property_id');
            $table->string('value');//extra field for the pivot.
            $table->timestamps();
        });
         */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_tariff');
    }
}
