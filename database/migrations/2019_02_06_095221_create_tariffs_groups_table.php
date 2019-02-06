<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTariffsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id');
            $table->string('main_group');
            $table->integer('main_group_id');
            $table->string('sub_group');
            $table->integer('sub_group_id');
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
        Schema::dropIfExists('tariffs_groups');
    }
}
