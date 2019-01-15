<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMandotaryExclusionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mandotary_exclusion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vodafone_tariff_id');
            $table->integer('service_id');
            $table->smallInteger('mandotary_exclusion');
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
        Schema::dropIfExists('mandotary_exclusion');
    }
}
