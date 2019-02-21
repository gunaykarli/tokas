<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceVodafonetariffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_vodafonetariff', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vodafone_tariff_id');
            $table->foreign('vodafone_tariff_id')->references('id')->on('vodafone_tariffs');
            $table->integer('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->smallInteger('property');
            $table->boolean('is_favorite');
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
        Schema::dropIfExists('service_vodafonetariff');
    }
}
