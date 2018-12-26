<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealerRegionVbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_region_vbs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dealer_id');
            $table->string('dealer_postcode', 5);
            $table->string('provider_id');
            $table->string('region_id');
            $table->string('primary_VB_id');
            $table->string('secondary_VB_id');
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
        Schema::dropIfExists('dealer_region_vbs');
    }
}
