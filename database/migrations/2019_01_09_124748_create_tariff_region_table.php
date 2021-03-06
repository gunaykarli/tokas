<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTariffRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariff_region', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tariff_id');
            $table->integer('region_id');
            $table->integer('provider_id');// provider_id is extra attribute of this pivot table.

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
        Schema::dropIfExists('tariff_region');
    }
}
