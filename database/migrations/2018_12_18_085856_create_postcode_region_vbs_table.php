<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostcodeRegionVbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postcode_region_vbs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('postcode', 5);
            $table->integer('provider_id');
            $table->integer('region_id');
            $table->integer('primary_VB_id');
            $table->integer('secondary_VB_id');
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
        Schema::dropIfExists('postcode_region_vbs');
    }
}
